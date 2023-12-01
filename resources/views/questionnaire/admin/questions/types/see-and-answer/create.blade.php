<div class="form-group row mx-auto">
    <div class="col-12">
        <label for="body">Question Text</label>
        <input class="form-control @error('body') is-invalid @enderror"
               value="{{@old('body')}}"
               name="body"
               id="body"
        />
        @error('body')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="form-group row">
    @foreach(range(0,2) as $item)
        <div class="mx-auto col-3 mb-3 p-3 border border-1 border-info">
            <div id="correctAnsDiv" class="mb-4">
                <input type="hidden" name="items[{{$item}}][id]"
                       value="{{@old("items[$item][id]") ?? \Illuminate\Support\Str::orderedUuid()}}">
                <input class="form-control" type="text" name="items[{{$item}}][name]"
                       value="{{@old("items[$item][name]")}}" @required(true) placeholder="Image Name"/>
            </div>
            <div id="fileUpdateDiv">
                <label for="image_path">Image</label>
                <div id="filePathInput" class="input-group">
                    <input @readonly(true)
                           @required(true)
                           class="form-control @error('image_path') is-invalid @enderror"
                           name="items[{{$item}}][image_path]"
                           id="image_path"
                           value="{{@old('image_path')}}">
                    <div class="input-group-append">
                        <button id="upload-btn" class="btn btn-primary">Upload</button>
                    </div>
                </div>

                <input style="display: none" class="form-control @error('material') is-invalid @enderror"
                       type="file"
                       name="items[{{$item}}][material]"
                       id="material"
                       accept="image/*">
                @error('material')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <div class="progress mt-2">
                    <div
                        class="progress-bar"
                        role="progressbar"
                        style="width: 0;"
                        id="upload-progress"
                        aria-valuenow="25"
                        aria-valuemin="0"
                        aria-valuemax="100">0%
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
