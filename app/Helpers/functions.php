<?php

use App\Models\Course;
use Illuminate\Support\Facades\Session;

if (! function_exists('get_courses')) {
    function get_courses()
    {
        return Course::with('bookingDates')->withCount('bookingDates')->orderBy('display_order')->get();
    }
}

if (! function_exists('get_cart_count')) {
    function get_cart_count(): int
    {
        $count = 0;
        if (Session::has('cart')) {
            $count = count(Session::get('cart'));
        }

        return $count;
    }
}

if (! function_exists('get_cart_total')) {
    function get_cart_total(): float
    {
        $total = 0;
        if (Session::has('cart')) {
            $cart = Session::get('cart');
            foreach ($cart as $cartItem) {
                $slug = $cartItem['slug'];
                $course = Course::where('slug', $slug)->first();
                $total = floatval($course->price) + $total;
            }
        }

        return $total;
    }
}

if (! function_exists('generate_random_key')) {
    function generate_random_key(): string
    {
        return sprintf('%06d', mt_rand(1, 999999));
    }
}
