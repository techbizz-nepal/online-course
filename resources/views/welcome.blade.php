@extends('layouts.app')
@section('homepage', 'nav-active')
@section('title', $page?->title ?? "")
@section('metaTags')
    @if($metaTags && count($metaTags) > 0)
        @foreach($metaTags as $metaTag)
            <meta @if($metaTag->name !== null && trim($metaTag->name) !== '') name="{{ $metaTag->name }}" @endif @if($metaTag->property !== null && trim($metaTag->property) !== '') property="{{ $metaTag->property }}" @endif content="{{ $metaTag->content }}">
        @endforeach
    @endif
@endsection
@section('content')
    <div class="site-content">
        @if($banner)
        <div class="section section-hero">
            <span class="overlay"></span>
            <img class="hero-img" src="{{ asset('storage/images/banners/'.$banner->banner_image) }}" alt="Banner Image">
            <div class="hero-content">
                <div class="content">
                    <div class="container">

                        {{-- <h2>We offer <br> Traffic Management Courses<br> WHite Card Course<br> First Aid Courses<br> Electrical Spooter Course<br> Roller Operator course

                        </h2> --}}
                        <h2>{!! $banner->banner_text !!}</h2>
{{--                        <p><strong>--}}
                                <!--Limited Spaces,<br>
                                Reserve your spot today!</strong></p>-->
                                <!--<a href="contact.php" class="btn btn-white">Book Now</a>-->
                    </div>
                </div>
            </div>

        </div>
        @endif
        <!-- hero section ends -->

        <div class="section section-welcome">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-xl-6">
                        <div class="content__wrap">
                            <div class="content">
                                <h1>Welcome to KEY</h1>
                                <p>Learn more by joining the KEY family. Taught by professional and passionate educators. </p>
                                <ul>
                                    <li> </li>
                                    <li> </li>
                                    <li> </li>
                                    <li> </li>
                                    <li></li>
                                </ul>
                                <a href="{{ route('about') }}" class="btn btn-blue">Read More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-5 offset-xl-1">
                        <div class="image__wrap">
                            <img src="{{ asset('assets/images/welcome-image.jpg') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (count($categories) > 0)

        <div class="section section-career">
            <div class="container">
                <div class="section-title text-center">
                    <h2>COURSES WE OFFER:</h2>
                    <p>SEE YOU IN OUR NEXT CLASS</p>
                </div>
                <div class="row">
                    @foreach ($categories as $category)
                        <div class="col-md-6 col-lg-4">
                            <div class="career__wrap">
                                <div class="career__image">
                                    <img src="{{ asset($category->image) }}" alt="{{ $category->title }}">
                                </div>
                                <div class="career__content">
                                    <div class="career__title">
                                        <div class="title" id="test{{ $loop->iteration }}">
                                            <span>{{ $category->name }}</span>
                                        </div>
                                    </div>
                                    <div class="button-wrap">
                                        <ul>
                                            <li><a class="btn btn-blueLight" href="{{ route('category', $category) }}"><span>View Courses</span></a></li>
                                        </ul>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection
