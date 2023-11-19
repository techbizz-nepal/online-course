<?php

namespace App\Http\Controllers;

use App\Mail\PaymentNotification;
use App\Mail\PaymentSuccess;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Omnipay\Omnipay;

class PaymentController extends Controller
{
    public function paypal()
    {
        if (!Session::has('cart') || !Session::has('user-checkout-details')) {
            return redirect()->route('home')->withErrors('Failed to make payments. Please try again.');
        }
        if (Session::has('tac') && Session::get('tac')) {
            Session::remove('tac');
        } else {
            return redirect()->route('payment')->withErrors('Please agree to terms and conditions first');
        }
        $client_id = config('services.paypal.client_id');
        $secret_id = config('services.paypal.secret_id');
        $currency = config('services.paypal.currency');
        $testing = config('services.paypal.testing');

        $total = 0;
        $cart = Session::get('cart');
        $items = [];
        foreach ($cart as $cartItem) {
            $slug = $cartItem['slug'];
            $course = Course::where('slug', $slug)->first();
            $total = floatval($course->price) + $total;
            $item = [
                'name' => $course->title,
                'price' => $course->price,
                'description' => 'Course Code: ' . $course->course_code,
                'quantity' => 1,
            ];
            $items[] = $item;
        }
        try {
            $gateway = Omnipay::create('PayPal_Rest');
            $gateway->setClientId($client_id);
            $gateway->setSecret($secret_id);
            $gateway->setTestMode($testing);

            $response = $gateway->purchase([
                'amount' => $total,
                'items' => $items,
                'currency' => $currency,
                'returnUrl' => route('payment.success'),
                'cancelUrl' => route('payment.fail'),
            ])->send();
            Session::put('payment_method', 'Paypal');

            if ($response->isRedirect()) {
                $response->redirect();
            } else {
                dd($response->getMessage());
            }
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function ewaySuccess(Request $request)
    {
        Session::put('payment_method', 'EWay');
        if (!$request->has('AccessCode')) {
            return redirect()->route('payment.fail');
        }

        return redirect()->route('payment.success');
    }

    public function zipPay()
    {

        if (!Session::has('cart') || !Session::has('user-checkout-details')) {
            return redirect()->route('home')->withErrors('Failed to make payments. Please try again.');
        }
        if (Session::has('tac') && Session::get('tac')) {
            Session::remove('tac');
        } else {
            return redirect()->route('payment')->withErrors('Please agree to terms and conditions first');
        }

        $api_key = config('services.zippay.api_key');
        $baseURL = config('services.zippay.base_url');

        $checkOutEndPoint = $baseURL . '/checkouts';
        $chargeEndPoint = $baseURL . '/charges';

        // dd($api_key, $baseURL, $checkOutEndPoint);
        $userDetails = Session::get('user-checkout-details');

        $shopper = [
            'title' => $userDetails['title'],
            'first_name' => $userDetails['first_name'],
            'last_name' => $userDetails['surname'],
            'email' => $userDetails['email'],
            'phone' => $userDetails['mobile'],
        ];
        $cart = Session::get('cart');
        $items = [];
        $total = 0;
        $reference = date('Y') . uniqid();
        foreach ($cart as $key => $cartItem) {
            $slug = $cartItem['slug'];
            $course = Course::where('slug', $slug)->first();
            $total = floatval($course->price) + $total;
            $item = [
                'name' => $course->title,
                'amount' => $course->price,
                'quantity' => 1,
                'type' => 'sku',
                'reference' => (intval($key) + 1),
                'item_uri' => route('course', $course),
                'image_uri' => asset('storage/images/courses/' . $course->image),
            ];
            $items[] = $item;
        }
        $uniqueID = uniqid();
        $order = [
            'reference' => $reference,
            'amount' => $total,
            'currency' => 'AUD',
            'items' => $items,
            'shipping' => ['pickup' => false],
        ];
        $data = [
            'shopper' => $shopper,
            'order' => $order,
            'config' => ['redirect_uri' => route('zip.success')],
        ];
        $response = Http::withHeaders([
            'authorization' => 'Bearer ' . $api_key,
            'content-type' => 'application/json',
        ])->post($checkOutEndPoint, $data);
        // dd($response);
        // $response->throw();
        if ($response->failed()) {
            return redirect()->route('payment')->withErrors('Zip Payment Failed. Please try again.');
        }
        if ($response->successful()) {
            $checkOutResponse = json_decode($response->body());
            //            dd($checkOutResponse->uri);
            Session::put('zip-response', $checkOutResponse);

            return redirect($checkOutResponse->uri);
            //            return redirect($checkOutResponse->uri);
        }
    }

    public function zipSuccess()
    {
        if (!Session::has('zip-response') || Session::get('zip-response') === null) {
            return redirect()->route('payment');
        }
        $checkOutResponse = Session::get('zip-response');
        $total = get_cart_total();

        $api_key = config('services.zippay.api_key');
        $baseURL = config('services.zippay.base_url');
        $chargeEndPoint = $baseURL . '/charges/';
        $chargeData = [
            'authority' => [
                'type' => 'checkout_id',
                'value' => $checkOutResponse->id,
            ],
            'reference' => $checkOutResponse->order->reference,
            'amount' => $total,
            'currency' => 'AUD',
            'capture' => true,
        ];
        $chargeResponse = Http::withHeaders([
            'authorization' => 'Bearer ' . $api_key,
            'content-type' => 'application/json',
        ])->post($chargeEndPoint, $chargeData);
        Session::put('payment_method', 'Zip Pay');
        Session::forget('zip-response');
        if ($chargeResponse->successful()) {
            $verifyResponse = json_decode($chargeResponse->body());
            if ($verifyResponse->state === 'captured') {
                return redirect()->route('payment.success');
            }
        }
        // $chargeResponse->throw();
        if ($chargeResponse->failed()) {
            return redirect()->route('payment')->withErrors('Zip Payment Failed. Please try again.');
        }

        return redirect()->route('payment.fail');
    }

    public function paymentSuccess()
    {
        if (!Session::has('cart') || !Session::has('user-checkout-details') || !Session::has('payment_method')) {
            return redirect()->route('home')->withErrors('Failed to make payments. Please try again.');
        }
        $userDetails = Session::get('user-checkout-details');
        $paymentMethod = Session::get('payment_method');
        $cart = Session::get('cart');

        $courses = [];
        $total = 0;

        foreach ($cart as $cartItem) {
            $slug = $cartItem['slug'];
            $course = Course::query()->where('slug', $slug)->first();
            $booking_date = $cartItem['booking_date'];
            $item = [
                'name' => $course->title,
                'price' => $course->price,
                'description' => 'Course Code: ' . $course->course_code,
                'booking_date' => $booking_date,
            ];
            $total = floatval($course->price) + $total;
            $courses[] = $item;
            DB::table('course_student')->insert([
                'id' => Str::uuid(),
                'student_id' => $userDetails['student_id'],
                'course_id' => $course->id
            ]);
        }
        try {
            Mail::to($userDetails['email'])->send(
                new PaymentSuccess($courses, $userDetails, $paymentMethod, $total)
            );
            Mail::to(config('app.email'))->send(
                new PaymentNotification($courses, $userDetails, $paymentMethod, $total)
            );
        } catch (\Exception $exception) {
            Log::error("after payment success: ", [$exception->getMessage()]);
        } finally {
            Session::forget('user-checkout-details');
            Session::forget('cart');
            Session::forget('payment_method');
            return view('purchase.success');
        }
    }

    public function paymentFail()
    {
        if (!Session::has('cart') || !Session::has('user-checkout-details') || !Session::has('payment_method')) {
            return redirect()->route('home')->withErrors('Failed to make payments. Please try again.');
        }
        Session::forget('payment_method');

        return view('purchase.fail');
    }
}
