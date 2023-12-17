<x-mail::message>
# Student Registration
    Course: {{'ss'}}
    Email: {{$student->email}}
    Password: {{$password}}
    Login Url: {{$login_url}}

**_NOTE:_** Please change your password after login.

Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
