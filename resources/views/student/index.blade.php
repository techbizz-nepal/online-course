
<h1>Under Construction</h1>
{{--{{ auth()->guard('student')->user()->name }}--}}
<div class="row flex-row">
    <h2>Welcome Student</h2>
    <a href="javascript:void(0);" onclick="document.getElementById('logoutForm').submit();">
        <i class="fa fa-close"></i>Logout
        <form action="{{ route('student.postLogout') }}" method="POST" class="d-none" id="logoutForm">
            @csrf
        </form>
    </a>
</div>
