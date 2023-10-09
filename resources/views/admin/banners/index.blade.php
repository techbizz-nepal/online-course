@extends('admin.layout.app')
@section('banners', 'active')
@section('content')
    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>Current Banner</span>
            <a href="{{ route('admin.banner.edit', $banner) }}" class="btn btn-primary">Edit Banner</a>
        </h2>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="my-3">Banner Text</h4>
                        <div class="p-2">
                            {!! $banner->banner_text !!}
                        </div>
                        <hr />
                        <h4 class="my-3">Banner Image</h4>
                    </div>
                    <div class="col-md-8 col-md-offset-2">
                        <img src="{{ asset('storage/images/banners/'.$banner->banner_image) }}" class="img-fluid" alt="Banner Image">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
