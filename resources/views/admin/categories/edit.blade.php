@extends('admin.layout.app')
@section('content')


    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>Edit {{ $category->title }} Category</span>
        </h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <form action="{{ route('admin.category.update', $category) }}" method="POST" id="categoryForm" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="form-group row">
                    <div class="col-6">
                        <label for="name">Category Name</label>
                        <input value="{{ $category->name }}" required class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" placeholder="Category Title">
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="image">Category Image</label>
                        <input class="form-control @error('image') is-invalid @enderror" type="file" name="image" id="image" accept="image/*">
                        @error('image')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <label for="description">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="2" placeholder="Description">{{ $category->description }}</textarea>
                        @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="description">Display Order</label>
                        <input type="number" required value="{{ $category->display_order }}" class="form-control @error('display_order') is-invalid @enderror" name="display_order" id="display_order" placeholder="Display Order">
                        @error('display_order')
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
