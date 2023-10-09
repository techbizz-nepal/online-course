@extends('admin.layout.app')
@section('content')
    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>Meta Tags</span>
            <a href="{{ route('admin.meta-tag.create') }}" class="btn btn-primary">Add New Meta Tag</a>
        </h2>
        <div class="w-100 h-100 bg-white mx-2 p-2">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th class="text-center" style="width: 2%;">#</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Property</th>
                    <th class="text-center">Content</th>
                    <th class="text-center">Pages</th>
                    <th class="text-center" style="width: 13%;">Action</th>
                </tr>
                </thead>
                <tbody>
                @if(count($metaTags) > 0)
                    @foreach($metaTags as $metaTag)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $metaTag->name }}</td>
                            <td>{{ $metaTag->property }}</td>
                            <td>{{ $metaTag->content }}</td>
                            <td>
                                @foreach($metaTag->pages as $page)
                                    @if($loop->last)
                                        {{ $page->name }}
                                    @else
                                        {{ $page->name.', ' }}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('admin.meta-tag.edit', $metaTag) }}" class="btn btn-info mb-1">Edit</a><br>
                                <a href="javascript:void(0)" onclick="document.getElementById('deleteMetaTag{{ $loop->iteration }}').submit();" class="btn btn-danger">Delete</a>
                                <form action="{{ route('admin.meta-tag.destroy', $metaTag) }}" class="d-none" method="POST" id="deleteMetaTag{{ $loop->iteration }}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-center">No data found.</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
