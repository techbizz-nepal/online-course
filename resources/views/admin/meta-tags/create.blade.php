@extends('admin.layout.app')
@section('content')
    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>Add New Meta Tag</span>
        </h2>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <form action="{{ route('admin.meta-tag.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="m-3 border p-3">
                            <h4 class="mb-3">Select Pages</h4>
                            <div class="row">
                                @foreach($pages as $page)
                                    @if($loop->iteration % 3 !== 1)
                                        @continue
                                    @endif
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" name="pages[]" type="checkbox" value="{{ $page->slug }}" id="checkbox-{{ $page->slug }}">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                {{ $page->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                                @foreach($pages as $page)
                                    @if($loop->iteration % 3 !== 2)
                                        @continue
                                    @endif
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" name="pages[]" type="checkbox" value="{{ $page->slug }}" id="checkbox-{{ $page->slug }}">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                {{ $page->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                                @foreach($pages as $page)
                                    @if($loop->iteration % 3 !== 0)
                                        @continue
                                    @endif
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" name="pages[]" type="checkbox" value="{{ $page->slug }}" id="checkbox-{{ $page->slug }}">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                {{ $page->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @error('pages')
                <span class="text-danger my-1">{{ $message }}</span>
                @enderror
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="title">Name</label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" placeholder="Name">
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="title">Property</label>
                        <input class="form-control @error('property') is-invalid @enderror" type="text" name="property" id="property" placeholder="Name">
                        @error('property')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="title">Content</label>
                        <input class="form-control @error('content') is-invalid @enderror" type="text" name="content" id="content" placeholder="Content">
                        @error('content')
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
