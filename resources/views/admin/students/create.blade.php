@extends('admin.layout.app')
@section('content')


    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>Add New Student</span>
        </h2>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <form action="{{ route('admin.student.store') }}" method="POST" id="studentForm" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <div class="col-6">
                        <label for="name">Student Name</label>
                        <input @required(true) class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" placeholder="Student Name" value="{{old('name')}}">
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="pdf">PDF File</label>
                        <input @required(true) class="form-control @error('pdf') is-invalid @enderror" type="file" name="pdf" id="pdf" accept="application/pdf">
                        @error('pdf')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <label for="email">Email</label>
                        <input @required(true) class="form-control @error('email') is-invalid @enderror" type="email" name="email" id="email" placeholder="Student Email" value="{{old('email')}}">
                    </div>
                </div>
                <input type="hidden" name="submit" value="true">
                <div class="row">
                    <div class="col-md-12 text-left">
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
