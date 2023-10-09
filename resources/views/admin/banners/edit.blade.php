@extends('admin.layout.app')
@section('banners', 'active')
@section('content')


    <div class="main-content pt-lg-4">
        <h2 class="m-2 mb-0 d-flex justify-content-between">
            <span>Edit Banner</span>
        </h2>
        <div class="w-100 h-100 bg-white mx-2 p-4">
            @if ($errors->any())
                <div class="my-3 alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.banner.update', $banner) }}" method="POST" id="bannerForm" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-12">
                        <label for="banner_text">Banner Text</label>
                        <textarea class="form-control @error('banner_text') is-invalid @enderror" name="banner_text" id="banner_text" rows="7" placeholder="Banner Text">{{ $banner->banner_text }}</textarea>
                        @error('banner_text')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <hr />
                <div class="form-group row">
                    <div class="col-6">
                        <label for="banner_image">Banner Image</label>
                        <input class="form-control @error('banner_image') is-invalid @enderror" type="file" name="banner_image" id="banner_image" accept="image/*">
                        @error('banner_image')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
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
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush
@push('js')
 <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
      $('#banner_text').summernote({
        placeholder: 'Banner Text',
        height: 200,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ],
      });
</script>
@endpush