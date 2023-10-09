@extends('admin.layout.app')
@section('categories', 'active')
@section('content')
    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>All Categories</span>
            <a href="{{ route('admin.category.create') }}" class="btn btn-primary">Add New Category</a>
        </h2>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center" style="width: 30%;">Category</th>
                    <th class="text-center">Image</th>
                    <th class="text-center">Order</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                @if(count($categories) > 0)
                @foreach($categories as $category)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td class="text-center">{{ $category->name }}</td>
                    <td class="text-center">
                        <img alt="{{ $category->title }}" src="{{ asset($category->image) }}" class="img-thumbnail" style="height: 100px; width: 100px; object-fit: cover; object-position: center;">
                    </td>
                    <td>
                        {{ $category->display_order }}
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.category.edit', $category) }}" class="btn btn-info mb-1">Edit</a>
                        <br>
                        <a href="javascript:void(0)" onclick="document.getElementById('deleteCategory{{ $loop->iteration }}').submit();" class="btn btn-danger">Delete</a>
                        <form action="{{ route('admin.category.destroy', $category) }}" class="d-none" method="POST" id="deleteCategory{{ $loop->iteration }}">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td class="text-center" colspan="5">No Data Found</td>
                </tr>
                @endif

                </tbody>
            </table>
        </div>
    </div>
@endsection
