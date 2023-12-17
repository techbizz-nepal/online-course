@extends('admin.layout.app')
@section('content')

    <x-questionnaire.admin.create-type :$params >
        <div class="col-3">
            <label for="weight">Weight</label>
            <input required class="form-control @error('weight') is-invalid @enderror" type="number" name="weight"
                   value="{{@old('weight')}}"
                   id="weight">
        </div>
    </x-questionnaire.admin.create-type>
@endsection
