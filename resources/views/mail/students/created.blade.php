<x-mail::message>
# Student Registration
    Email: {{$student->email}}
    Password: {{$password}}

**_NOTE:_** Please change your password after login.

Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
