@extends('admin.layout.app')
@section('dashboard', 'active')
@section('content')
    <div class="main-content">
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <div class="mt-2">
                <a href="#" class="btn btn-primary my-2">View  Courses</a>
                <br>
                <a class="btn btn-danger my-2" href="javascript:void(0);" onclick="document.getElementById('logoutForm').submit();">Logout</a>
            </div>
        </div>
    </div>
@endsection
