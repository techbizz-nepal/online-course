<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function cart()
    {
        if (!Session::has('cart') || get_cart_count() === 0) {
            return redirect()->route('home')->withErrors('No items have been added to cart.');
        }
        $cart = Session::get('cart');
        $cartItems = [];
        $total = 0;
        foreach ($cart as $cartItem) {
            $course = Course::where('slug', $cartItem['slug'])->first();
            $total = floatval($course->price) + $total;
            array_push($cartItems, ['course' => $course, 'booking_date' => $cartItem['booking_date']]);
        }

        return view('purchase.cart', compact('cartItems', 'total'));
    }

    public function addToCart(Course $course, Request $request)
    {
        $request->validate([
            'cart' => 'required',
            // 'booking_date' => 'required | date | after-or-equal:today',
            'booking_date' => 'required | date',
        ]);
        if (!$course) {
            return back()->withErrors('Course Not Found');
        }
        //        $redirectToCart = !($request->get('cart') === 'false');
        $cart = [];
        if (Session::has('cart')) {
            $cart = Session::get('cart');
            $cartHasItem = false;
            foreach ($cart as $key => $cartItem) {
                $slug = trim($cartItem['slug']);
                if ($slug === $course->slug) {
                    $cart[$key]['booking_date'] = $request->get('booking_date');
                    $cartHasItem = true;
                    break;
                }
            }
            if (!$cartHasItem) {
                array_push($cart, ['slug' => $course->slug, 'booking_date' => $request->get('booking_date')]);
            }
        } else {
            array_push($cart, ['slug' => $course->slug, 'booking_date' => $request->get('booking_date')]);
        }
        Session::put('cart', $cart);

        // return redirect()->route('course', $course)->with('success', 'Course added to cart.');
        return redirect()->route('checkout')->with('success', 'Course added to cart.');
    }

    public function removeFromCart(Course $course)
    {
        if (!Session::has('cart') || get_cart_count() === 0) {
            return redirect()->route('home')->withErrors('No items have been added to cart.');
        }
        $cart = Session::get('cart');
        foreach ($cart as $key => $cartItem) {
            if (trim($cartItem['slug']) === $course->slug) {
                unset($cart[$key]);
                break;
            }
        }
        Session::put('cart', $cart);

        return redirect()->route('cart')->with('success', 'Courses Removed From Cart');

    }
}
