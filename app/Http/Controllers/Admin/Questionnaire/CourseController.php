<?php

namespace App\Http\Controllers\Admin\Questionnaire;

use App\DTO\CourseData;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseStoreRequest;
use App\Http\Requests\CourseUpdateRequest;
use App\Models\BookingDate;
use App\Models\Category;
use App\Models\Course;
use App\Models\Page;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    private const DEFAULT_PAGINATE = 5;

    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $courses = Course::query()
            ->select(['id', 'slug', 'title', 'price', 'course_code', 'course_length', 'campus', 'category_id'])
            ->with('bookingDates')
        ->withCount('bookingDates')
        ->orderBy('display_order')
        ->simplePaginate(self::DEFAULT_PAGINATE);
        $viewData = [
            'courses' => $courses,
            'next_page_url' => $courses->nextPageUrl(),
            'prev_page_url' => $courses->previousPageUrl()
        ];
        return view('questionnaire.admin.courses.index', $viewData);
    }

    public function create(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $categories = Category::query()->orderBy('display_order')->get();
        return view('questionnaire.admin.courses.create', compact('categories'));
    }

    public function store(CourseStoreRequest $request): RedirectResponse
    {
        $data = CourseData::from($request)->toArray();
        DB::beginTransaction();
        try {
            $originalSlug = Str::slug($data['title'], '-');
            $slug = $originalSlug;
            $count = 1;
            $slugExists = (bool)Course::where('slug', $slug)->first();

            $order = Course::max('display_order') + 1;
            while ($slugExists) {
                $slug = $originalSlug . '-' . $count;
                $slugExists = (bool)Course::where('slug', $slug)->first();
                $count = $count + 1;
            }

            $image = $request->file('image');
            $detail_image = $request->file('course_details_image');

            $imageName = $slug . '-' . uniqid() . '.' . $image->extension();
            $detailImageName = 'details-' . uniqid() . '.' . $detail_image->extension();
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

            foreach ($dates as $date) {
                $bookingDate = date("Y-m-d", strtotime($date));
                BookingDate::create([
                    'course_id' => $course->id,
                    'booking_date' => $bookingDate
                ]);
            }

            DB::commit();
        } catch (\Exception $exception) {
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
        foreach ($course->bookingDates as $date) {
            array_push($dates, strval($date->booking_date));
        }
        return view('questionnaire.admin.courses.edit', compact('categories', 'course', 'dates'));
    }

    public function update(CourseUpdateRequest $request, Course $course): RedirectResponse
    {
        $data = CourseData::from($request);
        DB::beginTransaction();
        try {
            $count = 1;
            $slugExists = Course::query()
                ->where('slug', $data->slug)
                ->where('id', '<>', $course->getAttributeValue('id'))
                ->count();
            while ($slugExists) {
                $slug = $data->slug . '-' . $count;
                $slugExists = Course::query()->where('slug', $slug)->count();
                $count = $count + 1;
            }

            if ($request->has('image')) {
                $image = $request->file('image');
                $imageName = $data->slug . '-' . uniqid() . '.' . $image->extension();
                $image->move(public_path('storage/images/courses'), $imageName);
                $data->image = $imageName;
            }
            if ($request->has('course_details_image')) {
                $detail_image = $request->file('course_details_image');
                $detailImageName = 'details-' . uniqid() . '.' . $detail_image->extension();
                $detail_image->move(public_path('storage/images/courses'), $detailImageName);
                $data->detail_image = $detailImageName;
            }
            $dateArray = explode(",", $data->booking_dates);

            $course->update($data->except('course_details_image', 'booking_dates')->toArray());

            $course = Course::query()->find($course->getAttributeValue('id'));
            $course->page?->update([
                'name' => $course->getAttributeValue('title'),
                'title' => 'Course | ' . $course->getAttributeValue('title'),
                'slug' => $course->getAttributeValue('slug'),
                'is_course' => true,
                'course_id' => $course->getAttributeValue('id')
            ]);

            foreach ($course->getRelationValue('bookingDates') as $bd) {
                $bd->delete();
            }
            Arr::map($dateArray, function($date) use ($course){
                $bookingDate = date("Y-m-d", strtotime($date));
                BookingDate::query()->create([
                    'course_id' => $course->getAttributeValue('id'),
                    'booking_date' => $bookingDate
                ]);
            });

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->withErrors('Failed to update course'. $exception->getMessage());
        }
        return redirect()->route('admin.course.index')->with('success', 'Course Updated Successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return back()->with('success', 'Item Deleted Successfully');
    }
}
