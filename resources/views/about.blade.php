@extends('layouts.app')
@section('aboutpage', 'nav-active')
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
        <div class="section inner-hero" style="background-image: url({{ asset('assets/images/hero_gallery.png') }});">
            <div class="container">
                <div class="inner-hero-wrapper">
                    <div class="content">
                        <h1>About Us</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="section section-about">
            <div class="container">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="about__content">
                            <h3>About - KNOWLEDGE EMPOWERS YOU</h3>
                        </div>
                    </div>

                </div>
                <div class="row reverse">
                    <div class="col-lg-6">
                        <div class="about__image">
                            <img src="{{ asset('assets/images/dymmy-image.png') }}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about__content">

                            <p>At Knowledge Empowers You, we are committed to spirited learning, growth and professional development. We empower our students to ask insightful questions, explore disciplinary boundaries, and confront conventional ways of thinking. </p>
                            <p>Knowledge Empowers You invites all to come experience a rich and diverse learning environment. Creativity, hands-on learning and self improvement have always been at our core and both staff and students are encouraged to do so every passing day.</p>
                            <p>Our courses are completed using both theory and practical demonstrations. Apply online or Visit us at our office in Brooklyn.</p>
                            <a href="{{ route('contact') }}" class="btn btn-white">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--<div class="section section-workFlow">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="workFlow__left">
                            <h2>What we do</h2>
                            <ul>
                                <li><a href="#">- Lorem ipsum dolor sit</a></li>
                                <li><a href="#">- consectetur adipisicing elit</a></li>
                                <li><a href="#">- Molestias voluptates</a></li>
                                <li><a href="#">- rem facere vero</a></li>
                                <li><a href="#">- laborum quod alias molestias</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="workFlow__right">
                            <h2>Why Us?</h2>
                            <p>Our company has many advantages that lead to customer satisfaction and retention:</p>
                            <div class="row">
                                <div class="col-xl-6">
                                    <ul>
                                        <li>Use of Qualitative Materials</li>
                                        <li>Free Quotes</li>
                                        <li>Experienced and Professional</li>
                                    </ul>
                                </div>

                                <div class="col-xl-6">
                                    <ul>
                                        <li>Customer Service and Satisfaction </li>
                                        <li>Reliable and Cost-effective </li>
                                        <li>Licenced and Insured </li>
                                        <li>Quality Workmanship </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->


    </div>
@endsection
