<x-mail::message>
# Student Registration
    Name: {{$student->name}}
    Email: {{$student->email}}
    Password: {{$password}}

**_NOTE:_** Please change your password

Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
