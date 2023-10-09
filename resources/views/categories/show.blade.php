@extends('layouts.app')

@section('content')
    @if (count($courses) > 0)

        <div class="section section-career">
            <div class="container">
                <div class="section-title text-center">
                    <h2>{{ $category->name }} Courses:</h2>
                    <p>SEE YOU IN OUR NEXT CLASS</p>
                </div>
                <div class="row">
                    @foreach ($courses as $course)
                        <div class="col-md-6 col-lg-4">
                            <div class="career__wrap">
                                <div class="career__image">
                                    <img src="{{ asset('storage/images/courses/'.$course->image) }}" alt="{{ $course->title }}">
                                </div>
                                <div class="career__content">
                                    <div class="career__title">
                                        <div class="title" id="test{{ $loop->iteration }}">
                                            <span>{{ $course->title }}</span>
                                        </div>
                                        <div class="price">
                                            <span>${{ $course->price }}</span>
                                        </div>
                                    </div>
                                    <div class="button-wrap">
                                        <ul>
                                            <li><a class="btn btn-blueLight" href="{{ route('course', $course) }}"><span>View Course</span></a></li>
                                        </ul>

                                        <ul>
                                            <li><a class="btn btn-grey" href="{{ route('course', $course) }}"><span>Book Now</span></a></li>
                                        </ul>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else


        <div class="section section-career">
            <div class="container">
                <div class="section-title text-center text-danger">
                    <h2>No Courses Found</h2>
                    <p>
                        <button class="btn-grey">Go Back</button>
                    </p>
                </div>
            </div>
        </div>
    @endif
@endsection
