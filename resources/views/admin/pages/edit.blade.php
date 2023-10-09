@extends('admin.layout.app')
@section('content')
    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>Edit {{ $page->name }}</span>
        </h2>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <form action="{{ route('admin.page.update', $page) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="title">Title</label>
                        <input class="form-control @error('title') is-invalid @enderror" value="{{ $page->title }}" type="text" name="title" id="title" placeholder="Page Title">
                        @error('title')
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
