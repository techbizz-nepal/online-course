@extends('admin.layout.app')
@section('content')

    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>Add New Student</span>
        </h2>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <form action="{{ route('admin.student.store') }}" method="POST" id="studentForm"
                  enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <div class="col-8">
                        <label for="first_name">First Name</label>
                        <input @required(true) class="form-control @error('first_name') is-invalid @enderror"
                               type="text" name="first_name" id="first_name" placeholder="First Name"
                               value="{{old('first_name')}}">
                        @error('first_name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-8">
                        <label for="surname">Last Name</label>
                        <input @required(true) class="form-control @error('surname') is-invalid @enderror"
                               type="text" name="surname" id="surname" placeholder="Last Name"
                               value="{{old('surname')}}">
                        @error('surname')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-8">
                        <label for="pdf">PDF File</label>
                        <input @required(true) class="form-control @error('pdf') is-invalid @enderror" type="file"
                               name="pdf" id="pdf" accept="application/pdf">
                        @error('pdf')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <div class="form-group row">
                    <div class="col-8">
                        <label for="email">Email</label>
                        <input @required(true) class="form-control @error('email') is-invalid @enderror" type="email"
                               name="email" id="email" placeholder="Student Email" value="{{old('email')}}">
                    </div>
                </div>
                <input type="hidden" name="submit" value="true">
                <div class="row">
                    <div class="col-md-12 text-left">
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </div>
            </form>
            <h4 class="py-3">
                <i>Note: The newly created student's password will be set to <strong
                        class="text-warning">student123</strong> by default.</i>
            </h4>
        </div>
    </div>
@endsection
