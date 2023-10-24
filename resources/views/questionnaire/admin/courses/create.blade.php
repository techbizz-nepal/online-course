@extends('admin.layout.app')
@section('content')


    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>Add New Course</span>
        </h2>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <form action="{{ route('admin.courses.store') }}" method="POST" id="courseForm" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <div class="col-6">
                        <label for="title">Course Title</label>
                        <input required class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" placeholder="Course Title">
                        @error('title')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="price">Price</label>
                        <input min="0" required class="form-control @error('price') is-invalid @enderror" type="number" name="price" id="price" placeholder="Price">
                        @error('price')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="bookingDatePick">Select Booking Date</label>
                        <input required type="text" id="bookingDatePick" name="booking_dates" class="form-control @error('booking_dates') is-invalid @enderror" placeholder="Select Booking Date">
                        @error('booking_dates')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <label for="category">Category</label>
                        <select name="category_id" id="category" class="form-control @error('category') is-invalid @enderror">
                            <option selected disabled>Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $category->id == old('category') ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                            @error('category')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="image">Course Image</label>
                        <input required class="form-control @error('image') is-invalid @enderror" type="file" name="image" id="image" accept="image/*">
                        @error('image')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <label for="description">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="2" placeholder="Description"></textarea>
                        @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="courseCode">Course Code</label>
                        <input required class="form-control @error('course_code') is-invalid @enderror" type="text" name="course_code" id="courseCode" placeholder="Course Code">
                        @error('course_code')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <label for="campus">Campus</label>
                        <input required class="form-control @error('campus') is-invalid @enderror" type="text" name="campus" id="campus" placeholder="Campus">
                        @error('campus')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="studyArea">Study Area</label>
                        <input required class="form-control @error('study_area') is-invalid @enderror" type="text" name="study_area" id="studyArea" placeholder="Study Area">
                        @error('study_area')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <label for="courseLength">Course Length</label>
                        <input required class="form-control @error('course_length') is-invalid @enderror" type="text" name="course_length" id="courseLength" placeholder="Course Length">
                        @error('course_length')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="feeDetails">Fee Details</label>
                        <textarea required name="fee_details" class="form-control @error('fee_details') is-invalid @enderror" id="feeDetails" rows="2" placeholder="Fee Details"></textarea>
                        @error('fee_details')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <label for="prerequisites">Prerequisites</label>
                        <textarea name="prerequisites" class="form-control @error('prerequisites') is-invalid @enderror" id="prerequisites" rows="2" placeholder="Prerequisites (optional)"></textarea>
                        @error('prerequisites')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="course_duration">Course Duration</label>
                        <textarea name="course_duration" class="form-control @error('course_duration') is-invalid @enderror" id="course_duration" rows="2" placeholder="Course Duration (optional)"></textarea>
                        @error('course_duration')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <label for="detail_image">Course Details Image</label>
                        <input name="detail_image" type="file" accept="image/*" required class="form-control @error('detail_image') is-invalid @enderror" id="detail_image" placeholder="Detail Image">
                        @error('detail_image')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="additionalDetails">Additional Details</label>
                        <textarea name="additional_details" class="form-control @error('additional_details') is-invalid @enderror" id="additionalDetails" rows="2" placeholder="Additional Details (optional)"></textarea>
                        @error('additional_details')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
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
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/flatpicker.css') }}">
@endpush
@push('js')
    <script src="{{ asset('assets/vendor/calendar/js/jquery.plugin.min.js') }}"></script>
    <!--<script src="../vendor/calendar/js/jquery.datepick.js"></script>-->
    <script src="{{ asset('assets/js/flatpicker.js') }}"></script>
    <script>
        $(function() {
            const bookingDate = $('#bookingDatePick');
            bookingDate.flatpickr({
                mode: "multiple",
                dateFormat: "Y-m-d",
            });
            function dateChange(date){
                bookingDate.trigger('change');
            }
            bookingDate.on('change', function (){
                let val = bookingDate.val();
                let newVal = val.replace(',', ', ');
                bookingDate.val(newVal);
            });
        });
    </script>
@endpush
