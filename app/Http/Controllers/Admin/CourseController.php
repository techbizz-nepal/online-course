<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingDate;
use App\Models\Category;
use App\Models\Course;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CourseController extends Controller
{

    public function index()
    {
        $courses = Course::with('bookingDates')->withCount('bookingDates')->orderBy('display_order')->get();
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $categories = Category::orderBy('display_order')->get();
        return view('admin.courses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required | min: 1 | max: 149',
            'price' => 'required | numeric | min: 0',
            'booking_dates' => 'required | min: 1',
            'image' => 'required | image | max: 2048',
            'description' => 'max: 1500',
            'course_code' => 'required | min: 1 | max: 19',
            'campus' => 'required | min: 1 | max: 150',
            'study_area' => 'required | min: 1 | max: 150',
            'course_length' => 'required | min: 1 | max: 24',
            'fee_details' => 'required | min: 1 | max: 1500',
            'prerequisites' => 'max: 1500',
            'course_duration' => 'max: 1500',
            'additional_details' => 'max: 1500',
            'course_details_image' => 'required | image | max: 2048',
            'category' => 'required | exists:categories,id'
        ]);
        DB::beginTransaction();
        try {
            $originalSlug = Str::slug($data['title'], '-');
            $slug = $originalSlug;
            $count = 1;
            $slugExists = (bool) Course::where('slug', $slug)->first();

            $order = Course::max('display_order') + 1;
            while ($slugExists){
                $slug = $originalSlug.'-'.$count;
                $slugExists = (bool) Course::where('slug', $slug)->first();
                $count = $count + 1;
            }

            $image = $request->file('image');
            $detail_image = $request->file('course_details_image');

            $imageName = $slug.'-'.uniqid().'.'.$image->extension();
            $detailImageName = 'details-'.uniqid().'.'.$detail_image->extension();
            // dd($imageName);
            // dd(public_path('storage/images/courses'));

            // if($image->move(public_path('storage/images/courses'), $imageName)){
            //     dd('yes', $imageName);
            // }else{
            //     dd('no');
            // }

            $image->move(public_path('storage/images/courses'), $imageName);
            $detail_image->move(public_path('storage/images/courses'), $detailImageName);

            // $image->storeAs('public/images/courses', $imageName);
            // $detail_image->storeAs('public/images/courses', $detailImageName);
            // dd($imageName);

            $data['image'] = $imageName;
            $data['detail_image'] = $detailImageName;
            $data['slug'] = $slug;
            $data['display_order'] = $order;
            $data['category_id'] = $data['category'];

            $bookingDates = $data['booking_dates'];
            unset($data['booking_dates']);
            unset($data['course_details_image']);
            unset($data['category']);
            $dates = explode(",", $bookingDates);

            $course = Course::create($data);

            Page::create([
                'name' => $course->title,
                'slug' => $course->slug,
                'is_course' => true,
                'course_id' => $course->id
            ]);

            foreach ($dates as $date){
                $bookingDate = date("Y-m-d",strtotime($date));
                BookingDate::create([
                    'course_id' => $course->id,
                    'booking_date' => $bookingDate
                ]);
            }

            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            return back()->withErrors('Failed to create new course');
        }
        return redirect()->route('admin.course.index')->with('success', 'Course Added Successfully.');
    }

    public function show(Course $course)
    {
        return redirect()->route('admin.course.index');
    }

    public function edit(Course $course)
    {
        $categories = Category::orderBy('display_order')->get();
        $dates = [];
        foreach ($course->bookingDates as $date){
            array_push($dates, strval($date->booking_date));
        }
        return view('admin.courses.edit', compact('categories','course', 'dates'));
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'title' => 'required | min: 1 | max: 149',
            'price' => 'required | numeric | min: 0',
            'booking_dates' => 'required | min: 1',
            'image' => 'image | max: 2048',
            'description' => 'max: 1500',
            'course_code' => 'required | min: 1 | max: 19',
            'campus' => 'required | min: 1 | max: 150',
            'study_area' => 'required | min: 1 | max: 150',
            'course_length' => 'required | min: 1 | max: 24',
            'fee_details' => 'required | min: 1 | max: 1500',
            'prerequisites' => 'max: 1500',
            'course_duration' => 'max: 1500',
            'additional_details' => 'max: 1500',
            'course_details_image' => 'image | max: 2048',
            'display_order' => 'required | numeric | min: 0',
            'category' => 'required | exists:categories,id'
        ]);
        DB::beginTransaction();
        try {
            $originalSlug = Str::slug($data['title'], '-');
            $slug = $originalSlug;
            $count = 1;
            $slugExists = (bool) Course::where('slug', $slug)->where('id', '<>', $course->id)->first();
            while ($slugExists){
                $slug = $originalSlug.'-'.$count;
                $slugExists = (bool) Course::where('slug', $slug)->first();
                $count = $count + 1;
            }

            if ($request->has('image')){
                $image = $request->file('image');
                $imageName = $slug.'-'.uniqid().'.'.$image->extension();
                $image->move(public_path('storage/images/courses'), $imageName);
                $data['image'] = $imageName;
            }
            if ($request->has('course_details_image')){
                $detail_image = $request->file('course_details_image');
                $detailImageName = 'details-'.uniqid().'.'.$detail_image->extension();
                $detail_image->move(public_path('storage/images/courses'), $detailImageName);
                $data['detail_image'] = $detailImageName;
            }

            $data['slug'] = $slug;
            $data['category_id'] = $data['category'];

            $bookingDates = $data['booking_dates'];
            unset($data['booking_dates']);
            unset($data['course_details_image']);
            unset($data['category']);
            $dates = explode(",", $bookingDates);

            $course->update($data);
            $course = Course::find($course->id);
            if ($course->page !== null){
                $course->page->update([
                    'name' => $course->title,
                    'title' => 'Course | '.$course->title,
                    'slug' => $course->slug,
                    'is_course' => true,
                    'course_id' => $course->id
                ]);
            }

            foreach ($course->bookingDates as $bd){
                $bd->delete();
            }
            foreach ($dates as $date){
                $bookingDate = date("Y-m-d",strtotime($date));
                BookingDate::create([
                    'course_id' => $course->id,
                    'booking_date' => $bookingDate
                ]);
            }

            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            return back()->withErrors('Failed to update course');
        }
        return redirect()->route('admin.course.index')->with('success', 'Course Updated Successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return back()->with('success', 'Item Deleted Successfully');
    }
}
