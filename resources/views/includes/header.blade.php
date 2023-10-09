<header class="header-site">
    <div class="header-top">
        <div class="container">
            <div class="header-address">
                <ul>
                    <li><a href="mailto:info@key.edu.au"> <i class="fa fa-envelop"></i>info@key.edu.au</a></li>
                    <li><i class="fa fa-time"></i> Opening Hours: Mon - Fri: 9am - 4.30pm</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="logo_wrap">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="logo">
                        <a href="/"><img src="{{ asset('assets/images/logo.png') }}" alt="Knowledge empowers you"> <b>K</b>nowledge <b>E</b>mpowers <b>y</b>ou</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="enquire">
                        <ul>
                            <li class="inquire"><a href="{{ route('contact') }}">Enquire online</a></li>
                            <li class="call"><a href="tel:0420774595"><i class="fa fa-mobile"></i>0420 774 595</a></li>

                            @if(session()->has('cart') && get_cart_count() > 0)
                            <li class="nav-cart"><a href="{{ route('cart') }}"><i style="" class="fa fa-shopping-cart"></i> {{ get_cart_count() }}</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <nav class="navbar navbar-expand-md">
        <div class="container">
            <div class="stellarnav">
                <!--<a class="navbar-brand primary-logo" href="/"><img src="{{ asset('assets/images/logo.png') }}" alt="Planet Infosys"></a>-->
                <a class="navbar-brand primary-logo" href="./">
                  <img src="{{ asset('assets/images/logo.png') }}" alt="Knowledge empowers you"> <b>K</b>nowledge <b>E</b>mpowers <b>y</b>ou
                </a>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-home"><a href="/" class="@yield('homepage')"><i class="fa fa-home"></i> Home</a></li>
                    <li class="nav-product"><a href="#" class="@yield('courses')">Courses</a>
                        <ul id="course-list">
                            @foreach(get_courses() as $course)
                                <li><a href="{{ route('course', $course) }}">{{ $course->title }}</a></li>
                            @endforeach
                        </ul>
                    </li>

                    <li class="nav-about"><a href="{{ route('about') }}" class="@yield('aboutpage')">About Us</a></li>
                    <!--<li class="nav-gallery"><a href="/gallery.php">Gallery</a></li>-->
                    <li class="nav-contact"><a href="{{ route('contact') }}" class="@yield('contactpage')">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- end nav  -->
</header>
