@extends('layouts.app')
@section('courses', 'nav-active')
@section('title', $page->title)
@section('metaTags')
    @if(count($metaTags) > 0)
        @foreach($metaTags as $metaTag)
            <meta @if($metaTag->name !== null && trim($metaTag->name) !== '') name="{{ $metaTag->name }}" @endif @if($metaTag->property !== null && trim($metaTag->property) !== '') property="{{ $metaTag->property }}" @endif content="{{ $metaTag->content }}">
        @endforeach
    @endif
@endsection
@section('content')
    <div class="site-content">
        <div class="section inner-hero" style="background-image: url('{{ asset('assets/images/hero_gallery.png') }}');">
            <div class="container">
                <div class="inner-hero-wrapper">
                    <div class="content">
                        <h1>Our Courses</h1>
                    </div>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif


        <div class="section section-course">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="course__wrap">
                            <div class="course__content">
                                <h3>{{ $course->title }}</h3>
                                <p>{{ $course->description }}</p>
                            </div>
                            <div class="course__info">
                                <p><strong>{{ $course->title }}</strong></p>
                                <ul>
                                    <li>
                                        <span class="title">Courde Code</span>
                                        <span class="desc">{{ $course->course_code }}</span>
                                    </li>
                                    <li>
                                        <span class="title">Study Area(s</span>
                                        <span class="desc">{{ $course->study_area }}</span>
                                    </li>
                                    <li>
                                        <span class="title">Campus</span>
                                        <span class="desc">{{ $course->campus }}</span>
                                    </li>
                                    <li>
                                        <span class="title">Course Length</span>
                                        <span class="desc">{{ $course->course_length }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="course__faq">
                                <!-- <h3>Frequently asked Questions</h3> -->
                                <div class="accordion" id="course">
                                    <div class="card">
                                        <div class="card-header" id="heading-1">
                                            <button class="btn" type="button" data-toggle="collapse" data-target="#collapse-1" aria-expanded="true" aria-controls="collapse-1">
                                                Fees
                                            </button>
                                        </div>

                                        <div id="collapse-1" class="collapse show" aria-labelledby="heading-1" data-parent="#course">
                                            <div class="card-body">
                                                <p>{{ $course->fee_details }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading-2">
                                            <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#collapse-2" aria-expanded="false" aria-controls="collapse-2">
                                                Pre-requisites
                                            </button>
                                        </div>
                                        <div id="collapse-2" class="collapse" aria-labelledby="heading-2" data-parent="#course">
                                            <div class="card-body">
                                                @if (trim($course->prerequisites) !== '')
                                                    {{ $course->prerequisites }}
                                                @else
                                                <p>There are no prerequisites required for this course.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header" id="heading-3">
                                            <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#collapse-3" aria-expanded="false" aria-controls="collapse-3">
                                                Dates
                                            </button>
                                        </div>
                                        <div id="collapse-3" class="collapse" aria-labelledby="heading-3" data-parent="#course">
                                            <div class="card-body">
                                                <p>{{ $course->course_duration }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading-4">
                                            <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#collapse-4" aria-expanded="false" aria-controls="collapse-4">
                                                Apply
                                            </button>
                                        </div>
                                        <div id="collapse-4" class="collapse" aria-labelledby="heading-4" data-parent="#course">
                                            <div class="card-body">
                                                @if (trim($course->additional_details) !== '')
                                                    {{ $course->additional_details }}
                                                @else
                                                <p>There are no additional details provided for this course.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="bookingModalLabel">Select Booking Date</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('addToCart', $course) }}" method="POST" id="bookingDateForm">
                                                        @csrf
                                                        <input type="hidden" name="cart" id="cartValue">
                                                        <div class="row">
                                                            <div class="form-group col-md-8">
                                                                <label for="bookingDateCourse">Select Booking Date:</label>
                                                                <input type="text" placeholder="Select Booking Date" name="booking_date" class="selected-date form-control" id="bookingDateCourse">
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer book-now text-md-right">
                                                    <ul>
                                                        <li><a href="javascript:void(0);" class="btn" id="bookNowBtn"><span>Book Now</span></a></li>
                                                        <li><a href="javascript:void(0);" class="btn btn-blueLight" id="addToCartBtn"><span>Add To Cart</span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="book-now text-md-right mb-3">
                                <ul>
                                    <li><a class="btn"  href="javascript:void(0);" data-toggle="modal" data-target="#bookingModal"><span>Select Date</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- col ends -->
                    <div class="col-lg-5">
                        <div class="course__image">
                            <img src="{{ asset('storage/images/courses/'.$course->detail_image) }}" alt="{{ $course->title }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')

    <script>
        enabledDates = @json($dates);
        selectedDate = enabledDates[0] ?? null;
        $('#bookingDateCourse').flatpickr({
            inline: true,
            dateFormat: 'Y-m-d',
            enable: enabledDates,
            defaultDate: selectedDate,
        });
        $('#bookNowBtn').on('click', function (){
            $('#cartValue').val('false');
            $('#bookingDateForm').submit();
        });
        $('#addToCartBtn').on('click', function (){
            $('#cartValue').val('true');
            $('#bookingDateForm').submit();
        });
    </script>
@endpush
