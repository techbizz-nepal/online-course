<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Course;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PagesController extends Controller
{
    public function index()
    {
        //        $courses = Course::with('bookingDates')->withCount('bookingDates')->orderBy('display_order')->get();
        $categories = Category::with('courses')->orderBy('display_order')->get();
        $page = Page::where('slug', 'home')->with('metaTags')->first();
        $metaTags = $page?->metaTags;
        $banner = Banner::first();

        return view('welcome', compact('categories', 'page', 'metaTags', 'banner'));
    }

    public function about()
    {
        $page = Page::where('slug', 'about')->with('metaTags')->first();
        $metaTags = $page?->metaTags;

        return view('about', compact('page', 'metaTags'));
    }

    public function course(Course $course)
    {
        $dates = $course->bookingDates()->pluck('booking_date')->toArray();
        $page = $course->page()->with('metaTags')->first();
        $metaTags = $page->metaTags;

        return view('courses.show', compact('course', 'dates', 'page', 'metaTags'));
    }

    public function category(Category $category)
    {
        $courses = $category->courses;
        $page = Page::where('slug', 'category')->with('metaTags')->first();
        $metaTags = $page->metaTags;

        return view('categories.show', compact('courses', 'category', 'page', 'metaTags'));
    }

    public function contact()
    {
        $page = Page::where('slug', 'contact')->with('metaTags')->first();
        $metaTags = $page->metaTags;

        return view('contact', compact('page', 'metaTags'));
    }

    public function sendMessage(Request $request)
    {
        $details = $request->validate([
            'name' => 'required | min: 1 | max: 150',
            'address' => 'required | min: 1 | max: 250',
            'email' => 'required | email',
            'phone' => 'required | min: 1 | max: 15',
            'message' => 'required | min: 1 | max: 2000',
        ]);
        //        return new ContactMail($details);
        try {
            Mail::to('info@key.edu.au')->send(new ContactMail($details));
        } catch (\Exception $exception) {
            // dd($exception);
            return back()->withErrors('Failed to send Email.');
        }

        return back()->with('success', 'Thank you, Your inquiry has been sent.');
    }
}
