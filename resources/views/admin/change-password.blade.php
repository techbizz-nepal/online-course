@extends('admin.layout.app')
@section('courses', 'active')
@section('content')
    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>Change Password</span>
        </h2>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <form action="{{ route('admin.password.change') }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="form-group row">
                    <div class="col-6">
                        <label for="password">New Password</label>
                        <input required class="form-control @error('password') is-invalid @enderror" type="password" name="password" id="password" placeholder="New Password">
                        @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <label for="password_confirmation">Confirm Password</label>
                        <input required class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
                        @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
