<div class="form-group row">
    <div class="col-6">
        <input name="option1"
               type="text" class="form-control mb-2 @error('option1') is-invalid @enderror"
               placeholder="option 1"
               value="{{@old("option1")}}"
        >
        @error('option1')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-6 form-check py-2">
        <input type="radio"
               name="choose"
               class="form-check-input"
               id="option1" @checked(true)>
    </div>
</div>
<div class="form-group row">
    <div class="col-6">
        <input name="option2"
               type="text"
               class="form-control mb-2 @error('option2') is-invalid @enderror"
               placeholder="option 2"
               value="{{@old("option2")}}"
        >
        @error('option2')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-6 form-check py-2">
        <input type="radio"
               name="choose"
               class="form-check-input"
               id="option2">
    </div>
</div>
<div class="form-group row option3">
    <div class="col-6">
        <input name="option3"
               type="text"
               class="form-control mb-2 @error('option3') is-invalid @enderror"
               placeholder="option 3"
               value="{{@old("option3")}}"
        >
        @error('option3')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-6 form-check py-2">
        <input type="radio" name="choose" class="form-check-input" id="option3">
    </div>
</div>
<div class="form-group row option4">
    <div class="col-6">
        <input name="option4"
               type="text"
               class="form-control mb-2 @error('option4') is-invalid @enderror"
               placeholder="option 4"
               value="{{@old("option4")}}"
        >
        @error('option4')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-6 form-check py-2">
        <input type="radio" name="choose" class="form-check-input" id="option4">
    </div>
    <input type="hidden" name="is_correct">
</div>
@push('js')
    <script>
        const choose = document.querySelectorAll("input[name=choose]")
        const isCorrect = document.querySelector("input[name=is_correct]")

        choose.forEach((value) => {
            // initialize isCorrect value
            if(value.checked) {
                isCorrect.value = value.id
            }
            // change isCorrect value after triggering event
            value.addEventListener('change', (event) => {
                event.preventDefault()
                isCorrect.value = event.currentTarget.id
            })
        })

    </script>
@endpush
