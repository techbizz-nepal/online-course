<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title Page-->
    <title>Admin Dashboard</title>

    <!-- Fontfaces CSS-->
    <link href="{{ asset('assets/css/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('assets/vendor/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('assets/vendor/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('assets/vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="{{ asset('assets/vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="{{ asset('assets/vendor/animsition/animsition.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('assets/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('assets/vendor/css-hamburgers/hamburgers.min.css') }}" rel="stylesheet" media="all">


    <!-- Main CSS-->
    <link href="{{ asset('assets/css/theme.css') }}" rel="stylesheet" media="all">
    @stack('css')

</head>

<body>
@if(session()->has('success'))
    <div id="toast-success">{{ session()->get('success') }}</div>
@elseif(session()->has('error'))
    <div id="toast-error">{{ session()->get('success') }}</div>
@elseif(isset($errors) && $errors->any())
    <div id="toast-error">{{ $errors->first() }}</div>
@endif
<div class="page-wrapper">
    <!-- HEADER MOBILE-->
    <header class="header-mobile d-block d-lg-none">
        <div class="header-mobile__bar">
            <div class="container-fluid">
                <div class="header-mobile-inner">
                    <a class="logo" href="{{ route('admin.dashboard') }}">
                        <img src="{{ asset('assets/images/logo-primary.png') }}" alt="Knowledge Empowers You" />
                    </a>
                    <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                    </button>
                </div>
            </div>
        </div>
        <nav class="navbar-mobile">
            <div class="container-fluid">
                <ul class="navbar-mobile__list list-unstyled">
                    <li class="active">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                    </li>
                    <li>
                        <a href="{{ route('home') }}">
                            <i class="fas fa-home"></i>Go To Home</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.course.index') }}">
                            <i class="fas fa-book"></i>Courses</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.category.index') }}">
                            <i class="fas fa-clipboard-list"></i>Categories</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.student.index') }}">
                            <i class="fas fa-graduation-cap"></i>Students</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.page.index') }}">
                            <i class="fas fa-book"></i>Pages</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.meta-tag.index') }}">
                            <i class="fas fa-book"></i>Meta Tags</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.password.change') }}">
                            <i class="fas fa-book"></i>Change Password</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" onclick="document.getElementById('logoutForm').submit();">
                            <i class="fa fa-close"></i>Logout
                            <form action="{{ route('admin.logout') }}" method="POST" class="d-none" id="logoutForm">
                                @csrf
                            </form>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <aside class="menu-sidebar d-none d-lg-block">
        <div class="logo">
            <a href="#">
                <img src="{{ asset('assets/images/logo-primary.png') }}" alt="Knowledge Empowers You." />
            </a>
        </div>
        <div class="menu-sidebar__content js-scrollbar1">
            <nav class="navbar-sidebar pt-3">
                <ul class="list-unstyled navbar__list">
                    <li class="@yield('dashboard')">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                    </li>
                    <li>
                        <a href="{{ route('home') }}">
                            <i class="fas fa-home"></i>Go To Home</a>
                    </li>
                    <li class="@yield('categories')">
                        <a href="{{ route('admin.category.index') }}">
                            <i class="fas fa-clipboard-list"></i>Categories</a>
                    </li>
                    <li class="@yield('courses')">
                        <a href="{{ route('admin.course.index') }}">
                            <i class="fas fa-book"></i>Courses</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.student.index') }}">
                            <i class="fas fa-graduation-cap"></i>Students</a>
                    </li>
                    <li class="@yield('pages')">
                        <a href="{{ route('admin.page.index') }}">
                            <i class="fas fa-copy"></i> Pages
                        </a>
                    </li>
                    <li class="@yield('banners')">
                        <a href="{{ route('admin.banner.index') }}">
                            <i class="fas fa-clipboard"></i> Banners
                        </a>
                    </li>
                    <li class="@yield('meta-tags')">
                        <a href="{{ route('admin.meta-tag.index') }}">
                            <i class="fas fa-tags"></i>Meta Tags</a>
                    </li>
                    <li class="@yield('password')">
                        <a href="{{ route('admin.password.change') }}">
                            <i class="fas fa-lock"></i>Change Password</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" onclick="document.getElementById('logoutForm').submit();">
                            <i class="fa fa-close"></i>Logout
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
    <div class="page-container">
        @yield('content')
    </div>

</div>

<!-- Jquery JS-->
<script src="{{ asset('assets/vendor/jquery-3.2.1.min.js') }}"></script>
<!-- Bootstrap JS-->
<script src="{{ asset('assets/vendor/bootstrap-4.1/popper.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/vendor/animsition/animsition.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
<script src="{{ asset('assets/vendor/swal/swal.min.js') }}"></script>

<!-- Main JS-->
<script src="{{ asset('assets/js/admin-main.js') }}"></script>
<script src="{{ asset('assets/js/toast.js') }}"></script>
@stack('js')

</body>

</html>
