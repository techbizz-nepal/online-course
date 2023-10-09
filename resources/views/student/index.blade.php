<h1>Welcome Student</h1>
<a href="javascript:void(0);" onclick="document.getElementById('logoutForm').submit();">
    <i class="fa fa-close"></i>Logout
    <form action="{{ route('logout') }}" method="POST" class="d-none" id="logoutForm">
        @csrf
    </form>
</a>
{{ auth()->guard('student')->user() }}
