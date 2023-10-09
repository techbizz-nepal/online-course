@extends('layouts.app')
@section('content')
    <div class="site-content">
        <div class="section inner-hero" style="background-image: url({{ asset('assets/images/hero_gallery.png') }});">
            <div class="container">
                <div class="inner-hero-wrapper">
                    <div class="content">
                        <h1>Payment</h1>
                    </div>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="section section-course">
            <form action="{{ route('payment') }}" method="POST">
                @csrf
                <input type="hidden" name="payment_option" id="paymentOptionField">
                <div class="container">
                    <p class="alert alert-info">Please use email: <strong>{{$email}}</strong> and password:
                        <strong>{{$password}}</strong> for login.</p>
                    <div class="terms-and-policy">
                        <div class="form-group">
                            <div class="form-group form-check">
                                <input required type="checkbox" class="form-check-input" id="termsAndConditions">
                                <label class="form-check-label" for="exampleCheck1">I have read and agreed to the
                                    key.edu.au Terms and Condition for this Course <a
                                        href="{{ asset('Copyrights-key-2021.pdf') }}" target="_blank">Terms and
                                        Conditions*</a></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group form-check">
                                <input required type="checkbox" class="form-check-input" id="cancellationPolicy">
                                <label class="form-check-label" for="exampleCheck1">I have read and agreed to the
                                    key.edu.au Terms and Condition for this Course <a
                                        href="{{ asset('Cancelation_policy.pdf') }}" target="_blank">Cancellation
                                        Policy*</a></label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="payment__wrap">
                        <div class="row my-3">
                            <div class="col-12">
                                <h2>Payment Options</h2>
                            </div>
                            <hr>
                        </div>
                        <div class="row">
                            {{--                        <div class="col-xl-6">--}}
                            {{--                            <form method="POST" action="/">--}}

                            {{--                                <div class="form-group row">--}}
                            {{--                                    <label for="" class="col-sm-4 col-form-label">Card Holder Name:</label>--}}
                            {{--                                    <div class="col-sm-8">--}}
                            {{--                                        <input type="text" class="form-control" name="card_holder_name" id="card_holder_name" placeholder="Name as it appears on the card">--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                                <div class="form-group row">--}}
                            {{--                                    <label for="" class="col-sm-4 col-form-label">Card Number:</label>--}}
                            {{--                                    <div class="col-sm-8">--}}
                            {{--                                        <input required type="text" maxlength='16' class="form-control" name="card_number" id="card_number" placeholder="Card Number">--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                                <div class="form-group row">--}}
                            {{--                                    <label for="" class="col-sm-4 col-form-label">Expiration Date:</label>--}}
                            {{--                                    <div class="col-sm-8">--}}
                            {{--                                        <input required type="text" class="form-control" id="" name="expiration_date" placeholder="mm/yy">--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}

                            {{--                                <div class="form-group row">--}}
                            {{--                                    <label for="" class="col-sm-4 col-form-label">Security or CVV2 Number:</label>--}}
                            {{--                                    <div class="col-sm-8">--}}
                            {{--                                        <input required type="text" class="form-control" id="" placeholder="CVC/CVV" name="security_number" maxlength ='4'>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                                <div class="form-group">--}}
                            {{--                                    <div class="form-group form-check">--}}
                            {{--                                        <input required type="checkbox" class="form-check-input" id="exampleCheck1">--}}
                            {{--                                        <label class="form-check-label" for="exampleCheck1">I have read and agreed to the key.edu.au Terms and Condition for this Course <a href="Copyrights-key-2021.pdf" target="_blank">Terms and Conditions*</a></label>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                                <div class="form-group">--}}
                            {{--                                    <div class="form-group form-check">--}}
                            {{--                                        <input required type="checkbox" class="form-check-input" id="exampleCheck1">--}}
                            {{--                                        <label class="form-check-label" for="exampleCheck1">I have read and agreed to the key.edu.au Terms and Condition for this Course <a href="Cancelation_policy.pdf" target="_blank">Cancellation Policy*</a></label>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}

                            {{--                                <div class="form-group mt-4">--}}
                            {{--                                    <button type="submit" class="btn btn-blue">Purchase</button>--}}
                            {{--                                </div>--}}
                            {{--                            </form>--}}
                            {{--                        </div>--}}

                            <div class="col-md-4 mt-5 mt-md-2">
                                <h4 class="mb-2 mb-md-5">Pay with Eway</h4>
                                <ul>
                                    <li>
                                        <script src="https://secure.ewaypayments.com/scripts/eCrypt.js"
                                                class="eway-paynow-button"
                                                data-publicapikey="epk-DA7B3976-16A6-4746-B222-D61A9E3B5D42"
                                                data-amount="{{ floatval(get_cart_total()) * 100 }}"
                                                data-currency="AUD"
                                                data-invoiceref="{{ date('Y').'-'.uniqid() }}"
                                                data-allowedit="true"
                                                data-resulturl="{{ route('eway.success') }}"
                                                disabled
                                        >
                                        </script>
                                        {{--                                        <script src="https://secure.ewaypayments.com/scripts/eCrypt.js"--}}
                                        {{--                                                class="eway-paynow-button"--}}
                                        {{--                                                data-publicapikey="epk-2C24D559-209F-4F0B-8DD2-582A106D7A71"--}}
                                        {{--                                                data-amount="{{ floatval(get_cart_total()) * 100 }}"--}}
                                        {{--                                                data-currency="AUD"--}}
                                        {{--                                                data-resulturl="{{ route('eway.success') }}"--}}
                                        {{--                                        >--}}
                                        {{--                                        </script>--}}
                                    </li>
                                    <li>
                                        <div class="d-inline-block eway-pay-btn">
                                            <img src="{{ asset('assets/images/eway-2.png') }}" class="w-50"
                                                 alt="Pay with EWay">
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4 mt-5 mt-md-2">
                                <div>
                                    <h4 class="mb-2 mb-md-5">Pay with Zip</h4>
                                    <ul>
                                        <li><a class="payment-btn" id="zip"><img
                                                    src="{{ asset('assets/images/zip-logo.svg') }}" class="border"
                                                    alt="Pay with Zip"></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4 mt-5 mt-md-2">
                                <div>
                                    <h4 class="mb-2 mb-md-5">Pay with Paypal</h4>
                                    <ul>
                                        <li><a class="payment-btn" id="paypal"><img class="w-50"
                                                                                    src="{{ asset('assets/images/paypal-transparent.png') }}"
                                                                                    alt="Pay with paypal"></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="d-none">
                                <button class="d-none" id="paymentFormSubmitBtn" type="submit">Submit</button>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script>
        let isBothChecked = false;
        const dummyEwayBtn = $('.eway-pay-btn');
        let paymentBtn = $('.payment-btn');

        $(document).ready(function () {
            let ewayBtn = $('.eway-button').first();
            ewayBtn.hide();
            dummyEwayBtn.on('click', function () {
                checkBothChecked();
                if (isBothChecked) {
                    ewayBtn.click();
                } else {
                    $('#paymentFormSubmitBtn').click();
                }
            });
        });

        function checkBothChecked() {
            isBothChecked = $('#termsAndConditions').is(':checked') && $('#cancellationPolicy').is(':checked');
        }

        paymentBtn.on('click', function () {
            checkBothChecked();
            if (isBothChecked === true) {
                let paymentOption = this.id;
                $('#paymentOptionField').val(paymentOption);
                $('#paymentFormSubmitBtn').click();
            } else {
                $('#paymentFormSubmitBtn').click();
            }
        });


    </script>
@endpush
@push('css')
    <style>
        .eway-pay-btn:hover {
            cursor: pointer;
        }

        .payment-btn:hover {
            cursor: pointer;
        }
    </style>
@endpush
