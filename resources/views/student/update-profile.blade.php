@extends('student.layout.app')
@section('title', 'Update Profile')
@section('update-profile', 'active')
@section('content')
    <div class="main-content pt-lg-4 bg-flat-color-1 ">
        <h2 class="m-2 mb-0 d-flex justify-content-between text-white">
            <span>Update profile</span>
        </h2>
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <div class="w-100 h-100 bg-white mx-1 p-2">
            <form action="{{ route('student.updateProfile') }}" method="POST">
                @csrf
                <div class="form-row mb-5">
                    <x-form.input label="USI" name="usi" id="usi" type="text"
                                  :value="$student['usi']"
                                  helpText="Get new USI"
                                  helpLink="https://www.usi.gov.au/students/get-a-usi"
                                  cols="col-md-8 col-4"/>
                </div>
                <div class="form-row mb-5">
                    <x-form.select label="Title" name="title" id="title" cols="col-md-4 col-1"
                                   :options="$titleOptions" :value="$student['title']"/>
                    <x-form.select label="Gender" name="gender" id="gender" :options="$genderOptions"
                                   cols="col-md-4 col-1" :value="$student['gender']"/>
                    <x-form.input label="First Name" name="first_name" id="first_name" type="text"
                                  :value="$student['first_name']"
                                  required="true" cols="col-md-8 col-4"/>

                    <x-form.input label="Last Name" name="surname" id="surname" type="text" :value="$student['surname']"
                                  required="true" cols="col-md-8 col-4"/>

                    <x-form.input required="true" label="Date of birth" name="dob" id="dob" type="date" cols="col-2"
                                  :value="$student['dob']"/>

                </div>
                <div class="form-row mb-5">
                    <div class="col-12" id="heading">
                        <h4 class="mb-4 bg-flat-color-1 p-3 text-white">
                            Contact Information
                        </h4>
                    </div>
                    <x-form.input label="Home Phone" name="home_phone" id="home_phone" type="tel" required="true"
                                  :value="$student['home_phone']"
                                  pattern="[0-9]{10}" cols="col-md-8 col-3"/>

                    <x-form.input label="Work Phone" name="work_phone" id="work_phone" type="tel" required="true"
                                  :value="$student['work_phone']"
                                  pattern="[0-9]{10}" cols="col-md-8 col-3"/>

                    <x-form.input label="Mobile" name="mobile" id="mobile" type="tel"
                                  :value="$student['mobile']"
                                  required="true" pattern="[0-9]{10}" cols="col-md-8 col-3"/>

                    <x-form.input label="Email" name="email" id="email" type="email"
                                  required="true" cols="col-md-8 col-3" :value="$student['email']" :readonly="true"/>
                </div>
                <div class="form-row mb-5">
                    <div class="col-12" id="heading">
                        <h4 class="mb-4 bg-flat-color-1 p-3 text-white">
                            Address
                        </h4>
                    </div>
                    <x-form.input label="Flat/Unit" name="flat_unit" id="flat_unit" type="text"
                                  :value="$student['flat_unit']" required="true" cols="col-md-8 col-2"/>

                    <x-form.input label="Street" name="street" id="street" type="text"
                                  :value="$student['street']" required="true" cols="col-md-8 col-3"/>

                    <x-form.input label="Suburb, locality or town" name="locality" id="locality" type="text"
                                  required="true" :value="$student['locality']"
                                  cols="col-md-8 col-3"/>

                    <x-form.input label="State/Territory" name="state" id="state" type="text"
                                  required="true" cols="col-md-8 col-2" :value="$student['state']"/>

                    <x-form.input label="Post Code" name="post_code" id="post_code" type="number"
                                  required="true" pattern="[0-9]{4}" cols="col-md-8 col-2"
                                  :value="$student['post_code']"/>
                </div>
                <div class="form-row mb-5">
                    <div class="col-12" id="heading">
                        <h4 class="mb-4 bg-flat-color-1 p-3 text-white">
                            Next of kin/emergency contact
                        </h4>
                    </div>

                    <x-form.input label="Name" name="emergency_name" id="emergency_name" type="text"
                                  :value="$student['emergency_name']"
                                  cols="col-md-8 col-3"/>

                    <x-form.input label="Relationship to you" name="relation" id="relation" type="text"
                                  :value="$student['relation']"
                                  cols="col-md-8 col-3"/>

                    <x-form.input label="Home Phone" name="emergency_home_phone" id="emergency_home_phone" type="tel"
                                  required="true" pattern="[0-9]{10}"
                                  :value="$student['emergency_home_phone']" cols="col-md-8 col-2"/>

                    <x-form.input label="Work Phone" name="emergency_work_phone" id="emergency_work_phone" type="tel"
                                  required="true" pattern="[0-9]{10}"
                                  :value="$student['emergency_work_phone']" cols="col-md-8 col-2"/>

                    <x-form.input label="Mobile" name="emergency_mobile" id="emergency_mobile" type="tel"
                                  required="true" pattern="[0-9]{10}"
                                  :value="$student['emergency_mobile']" cols="col-md-8 col-2"/>
                </div>
                @isset($survey)
                    @foreach($survey as $key => $value)
                        <div class="row">
                            <div class="col-12" id="heading"><h4
                                    class="mb-4 bg-flat-color-1 p-3 text-white">{{$value['title']}}</h4></div>
                            @foreach($value['queries'] as $queryKey => $queryValue)
                                <div class="col-12"><p class="font-weight-bold">{{$queryValue['title']}}</p></div>
                                <div class="col-12 my-1"><p class="font-italic">{{$queryValue['subtitle']}}</p></div>

                                <div class="row col-12 m-1">
                                    @if(count($queryValue['choices']) && array_is_list($queryValue['choices']))
                                        @foreach($queryValue['choices'] as $choice)
                                            <div class="form-group form-inline pr-4">
                                                <label class="p-2" for="{{$choice['id']}}">{{$choice['label']}}</label>
                                                <input
                                                    class="form-control"
                                                    name="{{$choice['name']}}"
                                                    id="{{$choice['id']}}"
                                                    value="{{$choice['value']}}"
                                                    type="{{$choice['type']}}"
                                                    @checked($choice['checked'] ?? false)
                                                />
                                            </div>
                                        @endforeach
                                    @else
                                        @foreach($queryValue['choices'] as $assocKey => $assocChoices)
                                            <div class="col-12 col-md-4 mb-2">
                                                <div
                                                    class="row">{{str($assocKey)->replace('__', '/')->replace('_', ' ')->title()->replace('i', 'I')}}</div>
                                                <div class="row form-inline">
                                                    @if(count($assocChoices))
                                                        @foreach($assocChoices as $assocChoice)
                                                            <label class="p-2"
                                                                   for="{{$assocChoice['id']}}">{{$assocChoice['label']}}</label>
                                                            <input
                                                                class="form-control mr-3"
                                                                name="{{$assocChoice['name']}}"
                                                                id="{{$assocChoice['id']}}"
                                                                value="{{$assocChoice['value']}}"
                                                                type="{{$assocChoice['type']}}"
                                                            />
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @endisset
                <div>
                    <x-form.button>Update</x-form.button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script>
        const setDisplay = (element, value) => element.style.display = value

        const countryBornAustraliaEl = document.getElementById('country-born-australia')
        const countryBornOtherEl = document.getElementById('country-born-other')
        const countryBornSpecifyParentEl = document.getElementById('country-born-specify').parentElement

        const speakingLanguageEnglishEl = document.getElementById('speaking-language-english')
        const speakingLanguageOtherEl = document.getElementById('speaking-language-other')
        const speakingLanguageSpecifyParentEl = document.getElementById('speaking-language-specify').parentElement

        setDisplay(countryBornSpecifyParentEl, 'none')
        setDisplay(speakingLanguageSpecifyParentEl, 'none')

        countryBornOtherEl.addEventListener('change', () => setDisplay(countryBornSpecifyParentEl, 'flex'))
        countryBornAustraliaEl.addEventListener('change', () => setDisplay(countryBornSpecifyParentEl, 'none'))

        speakingLanguageOtherEl.addEventListener('change', () => setDisplay(speakingLanguageSpecifyParentEl, 'flex'))
        speakingLanguageEnglishEl.addEventListener('change', () => setDisplay(speakingLanguageSpecifyParentEl, 'none'))


    </script>
@endpush
