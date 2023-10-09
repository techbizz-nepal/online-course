@extends('admin.layout.app')
@section('pages', 'active')
@section('content')
    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>All Pages</span>
        </h2>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th class="text-center" style="width: 2%;">#</th>
                    <th class="text-center">Page Name</th>
                    <th class="text-center">Page Title</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                @if(count($pages) > 0)
                    @foreach($pages as $page)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td class="text-center">{{ $page->name }}</td>
                            <td class="text-center">{{ $page->title }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.page.edit', $page) }}" class="btn btn-info mb-1">Edit Title</a>
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
