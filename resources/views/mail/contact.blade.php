@component('mail::message')
# Dear KEY,
{{ $details['message'] }}
<br><br>
Thanks,<br>
{{ $details['name'] }}<br>
{{ $details['address'] }}<br>
Phone: {{ $details['phone'] }}<br>
Email: {{ $details['email'] }}<br>
@endcomponent
