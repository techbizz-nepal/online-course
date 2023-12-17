<?php

namespace App\Http\Controllers;

use App\DTO\StudentData;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PurchaseController extends Controller
{
    public function confirmPayment(Request $request)
    {
        $request->validate([
            'payment_option' => 'required',
        ]);
        Session::put('tac', true);
        if (trim(strtolower($request->get('payment_option'))) === 'zip') {
            return redirect()->route('zip');
        } elseif (trim(strtolower($request->get('payment_option'))) === 'paypal') {
            return redirect()->route('paypal');
        }
        Session::remove('tac');

        return redirect()->route('payment')->withErrors('Invalid Payment Option');
    }

    public function checkout()
    {
        if (! Session::has('cart') || get_cart_count() === 0) {
            return redirect()->route('home')->withErrors('No items have been added to cart.');
        }
        $cart = Session::get('cart');
        $cartItems = [];
        $total = 0;
        foreach ($cart as $cartItem) {
            $course = Course::where('slug', $cartItem['slug'])->first();
            $total = floatval($course->price) + $total;
            $cartItems[] = ['course' => $course, 'booking_date' => $cartItem['booking_date']];
        }

        return view('purchase.checkout', compact('cartItems', 'total'));
    }

    public function collectDetails(Request $request): RedirectResponse
    {
        $userDetails = $this->validateRequest($request);
        Session::put('user-checkout-details', $userDetails);

        return redirect()->route('payment');
    }

    public function payment()
    {
        if (! Session::has('cart') || ! Session::has('user-checkout-details') || get_cart_count() <= 0) {
            return redirect()->route('home')->withErrors('Cannot make payment. Make sure you have items in your cart or have filled in your user details form.');
        }
        $userEmail = Session::get('user-checkout-details')['email'];
        $defaultPassword = StudentData::DEFAULT_PASSWORD;

        return view('purchase.payment', ['email' => $userEmail, 'password' => $defaultPassword]);
    }

    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'title' => 'required | min: 1 | max: 6',
            'first_name' => 'required | min: 1 | max: 250',
            'surname' => 'required | min: 1 | max: 250',
            'dob' => 'required | min: 1 | date | before: today',
            'gender' => 'required | min: 1 | max: 10',
            'email' => 'required | min: 1 | max: 250 | email',
            'mobile' => 'required | min: 1 | max: 15',
            'flat_unit' => 'required | min: 1 | max: 500',
            'street' => 'required | min: 1 | max: 500',
            'locality' => 'required | min: 1 | max: 500',
            'post_code' => 'required | min: 1 | max: 500',
        ]);
    }

}
