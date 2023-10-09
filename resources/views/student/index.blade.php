<h1>Welcome Student</h1>
{{ auth()->guard('student')->user() }}
