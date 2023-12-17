@extends('admin.layout.app')
@section('content')
    <x-questionnaire.admin.edit-type :$question :$params >
        <div class="col-3">
            <label for="weight">Weight</label>
            <input required class="form-control @error('weight') is-invalid @enderror" type="number" name="weight"
                   value="{{$question->weight ?? @old('weight')}}"
                   id="weight">
        </div>
    </x-questionnaire.admin.edit-type>
@endsection
