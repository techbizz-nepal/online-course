@extends('layouts.app')
@section('content')
    <div class="site-content">
        <div class="section inner-hero" style="background-image: url({{ asset('assets/images/hero_gallery.png') }});">
            <div class="container">
                <div class="inner-hero-wrapper">
                    <div class="content">
                        <h1>Checkout</h1>
                    </div>
                </div>
            </div>
        </div>
        @if ($errors->any())
            <hr>
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <hr>
        @endif

        <div class="section section-duration" style="padding-bottom: 0;">
            <div class="container">
                <div class="table-responsive">
                    <h2 class="mb-2">Booked Courses</h2>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Course Name</th>
                            <th scope="col">Course Price</th>
                            <th scope="col">Booking Date</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($cartItems) > 0)
                        @foreach ($cartItems as $cartItem)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $cartItem['course']->title }}</td>
                            <td>$ {{ $cartItem['course']->price }}</td>
                            <td>{{ $cartItem['booking_date'] }}</td>
                            <td>
                                <a title="Remove From Cart" class="text-danger" href="{{ route('removeFromCart', $cartItem['course']) }}">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" class="text-right"><b>Total:</b></td>
                            <td colspan="2">$ {{ $total }}</td>
                        </tr>
                        @else
                            <tr>
                                <td colspan="5" class="text-center">0 Items in cart.</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    <div class="my-2 text-right">
                        <a href="{{ route('home') }}" class="btn btn-primary">Book Another</a>
                    </div>
                </div>
            </div>
        </div>
        @if(count($cartItems) > 0)
            <div class="section section-duration">
                <div class="container">
                    <form action="{{ route('checkout-details') }}" method="POST">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col" colspan="42">Personal Details</th>
                                </tr>
                                </thead>
                                <tbody>
                                <!--<tr>
                                    <th scope="row">Enter your full name</th>
                                    <td>
                                        <input required name="full_name" type="text" class="form-control">
                                    </td>
                                </tr>-->
                                <tr>
                                    <th scope="row">Title:</th>
                                    <td>
                                        <!-- Mr/Mrs/Miss/Ms/Dr -->
                                        <select required name="title" id="" class="form-control">
                                            <option value="Mr.">Mr</option>
                                            <option value="Mrs.">Mrs</option>
                                            <option value="Miss">Miss</option>
                                            <option value="Ms.">Ms</option>
                                            <option value="Dr.">Dr</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">First Name:</th>
                                    <td>
                                        <input required type="text" name="first_name" class="form-control" value="{{ old('first_name') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Surname:</th>
                                    <td>
                                        <input required type="text" name="surname" class="form-control" value="{{ old('surname') }}">
                                    </td>
                                </tr>
                                <!--<tr>-->
                                <!--    <th scope="row">Given names:</th>-->
                                <!--    <td>-->
                                <!--        <input required type="text" name="given_names" class="form-control" value="{{ old('given_names') }}">-->
                                <!--    </td>-->
                                <!--</tr>-->
                                <tr>
                                    <th scope="row">Date of Birth:</th>
                                    <td>
                                        <input required type="date" name="dob" class="form-control" value="{{ old('dob') }}">
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">Gender:</th>
                                    <td>
                                        <div class="radios">
                                            <input required type="radio" name="gender" id="male" value="male" {{ old('gender') !== 'female' ? 'checked' : '' }}>
                                            <label for="male">
                                                Male
                                            </label>

                                            <input required type="radio" name="gender" id="female" value="female" {{ old('gender') === 'female' ? 'checked' : '' }}>
                                            <label for="female">
                                                Female
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Mobile:</th>
                                    <td>
                                        <input required name="mobile" type="text" class="form-control" value="{{ old('mobile') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Email:</th>
                                    <td>
                                        <input required name="email" type="email" class="form-control" value="{{ old('email') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Flat/unit details:</th>
                                    <td>
                                        <input required name="flat_details" type="text" class="form-control" value="{{ old('flat_details') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Street name:</th>
                                    <td>
                                        <input required name="street_name" type="text" class="form-control" value="{{ old('street_name') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Suburb:</th>
                                    <td>
                                        <input required name="suburb" type="text" class="form-control" value="{{ old('suburb') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Post:</th>
                                    <td>
                                        <input required name="post" type="text" class="form-control" value="{{ old('post') }}">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="book-now text-md-right">
                            <button type="submit" class="btn btn-primary"><span>Submit</span></button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
@endsection
