@extends('layouts.app')
@section('content')
    <div class="site-content">
        <div class="section inner-hero" style="background-image: url('{{ asset('assets/images/hero_gallery.png') }}');">
            <div class="container">
                <div class="inner-hero-wrapper">
                    <div class="content">
                        <h1>My Cart</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="cart-section py-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead class="thead-dark">
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
                            @foreach($cartItems as $cartItem)
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
                        <div class="mt-3 text-right">
                            <a href="{{ route('checkout') }}" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
