@component('mail::message')
## Dear {{ $userDetails['title'] }} {{ $userDetails['surname'] }},

You have successfully completed the purchase of following items:
@component('mail::table')
| Course Name           | Price     | Booking Date |
|:------------------:   |:--------: |:----------   |
@foreach($courses as $course)
| {{ $course['name'] }} | ${{ $course['price'] }} | {{ $course['booking_date'] }} |
@endforeach
@endcomponent

Details of the payment are listed below: <br>
<br>
Payment Date: **{{ date('Y-m-d') }}** <br>
Payment Method: **{{ $paymentMethod }}** <br>
Payment Made By: **{{ $userDetails['title'] }} {{ $userDetails['first_name'] ?? '' }} {{ $userDetails['surname'] }}** <br>
Total Payment Amount: **${{ $total }}** <br>
## Payer's details:
Full Name: **{{ $userDetails['title'] }} {{ $userDetails['first_name'] ?? '' }} {{ $userDetails['surname'] }}** <br>
DOB: **{{ $userDetails['dob'] }}** <br>
Gender: **{{ $userDetails['gender'] }}** <br>
Email: **{{ $userDetails['email'] }}** <br>
Mobile: **{{ $userDetails['mobile'] ?? '' }}** <br>
Flat Details: **{{ $userDetails['flat_details'] ?? '' }}** <br>
Street Name: **{{ $userDetails['street_name'] ?? '' }}** <br>
Suburb: **{{ $userDetails['suburb'] ?? '' }}** <br>
Post: **{{ $userDetails['post'] ?? '' }}** <br>

To book more courses:
@component('mail::button', ['url' => route('home')])
Visit {{ config('app.name') }}
@endcomponent
<br>
If you have any concerns or questions, contact us at: info@key.edu.au
<br>
<br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
