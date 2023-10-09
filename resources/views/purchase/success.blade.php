@extends('layouts.app')
@section('content')
    <div class="site-content">
        <div class="section inner-hero" style="background-image: url({{ asset('assets/images/hero_gallery.png') }});">
            <div class="container">
                <div class="inner-hero-wrapper">
                    <div class="content">
                        <h1>Success</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 border p-5 my-5">
                    <h4 class="text-success">Payment was successful. Please check your email to view the details and confirmation of your purchase. Thank you!</h4>
                </div>
            </div>
        </div>
    </div>
@endsection
