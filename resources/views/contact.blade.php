@extends('layouts.app')
@section('contactpage', 'nav-active')
@section('title', $page->title)
@section('metaTags')
    @if(count($metaTags) > 0)
        @foreach($metaTags as $metaTag)
            <meta @if($metaTag->name !== null && trim($metaTag->name) !== '') name="{{ $metaTag->name }}" @endif @if($metaTag->property !== null && trim($metaTag->property) !== '') property="{{ $metaTag->property }}" @endif content="{{ $metaTag->content }}">
        @endforeach
    @endif
@endsection
@section('content')

    <div class="site-content">
        <div class="section inner-hero" style="background-image: url({{ asset('assets/images/contact_us.jpg') }});">
            <div class="container">
                <div class="inner-hero-wrapper">
                    <div class="content">
                        <h1>Contact</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="section section-contact">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="contact__info">
                            <h2>Please feel free to contact us if you have any queries or questions.</h2>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="contact__info">
                            <h2>Get in touch with our friendly staff.</h2>
                            <ul>
                                <li><strong>Phone:</strong><a href="tel:0420 774 595">0420 774 595</a></li>
                                <li><strong>Email:</strong><a href="mailto:info@key.edu.au">info@key.edu.au</a></li>
                                <li>
                                    <strong>Head Office:</strong>U2/1 Millers Road, Brooklyn VIC 3012<br>
                                    ABN: 15 613 868 901<br>
                                    RTO No: 45117
                                </li>

                            </ul>
                        </div>


                    </div>
                    <div class="col-md-6">
                        <div class="contact__form">
                            <h2>Please fill out the form below with your enquiry.</h2>
                            <div id="ContactForm">
                                <div class="alertmsg text-danger">
                                    @if ($errors->any())
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                @if(session()->has('success'))
                                    <div class="alert alert-success">
                                        {{ session()->get('success') }}
                                    </div>
                                @endif
                                <form method="POST" name="contactform" action="{{ route('contact') }}">
                                    @csrf
                                    @honeypot
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="form-group">
                                                <input type="name" name="name" value="{{ old('name') }}" placeholder="Full Name:" class="form-control" required />
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="form-group">
                                                <input type="add" name="address" value="{{ old('address') }}" placeholder="Address:" class="form-control" required />
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="form-group">
                                                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email:" class="form-control" required />
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="form-group">
                                                <input type="phone" value="{{ old('phone') }}" name="phone" placeholder="Phone:" class="form-control" required />
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="form-group">
                                                <textarea name="message" cols="30" rows="5" class="form-control textarea" placeholder="Message:" required>{{ old('message') }}</textarea>
                                            </div>
                                        </div>
                                    </div>

{{--                                    <div class="captcha-sec clearfix">--}}
{{--                                        <p> <img src="secureimage/securimage_show.php?sid=<?php echo md5(time()) ?>" width="120" align="left" id="siimage" style="padding-right:5px; padding-top:8px; border: 0" />--}}
{{--                                            <script type="text/javascript">--}}
{{--                                                AC_FL_RunContent( 'type','application/x-shockwave-flash','data','secureimage/securimage_play.swf?audio=secureimage/securimage_play.php&bgColor1=#8E9CB6&bgColor2=#fff&iconColor=#000&roundedCorner=5','id','SecurImage_as3','width','19','height','19','align','middle','allowscriptaccess','sameDomain','allowfullscreen','false','movie','secureimage/securimage_play?audio=secureimage/securimage_play.php&bgColor1=#8E9CB6&bgColor2=#fff&iconColor=#000&roundedCorner=5','quality','high','bgcolor','#ffffff' ); //end AC code--}}
{{--                                            </script>--}}
{{--                                        <noscript>--}}
{{--                                            <object type="application/x-shockwave-flash"--}}
{{--                                                    data="secureimage/securimage_play.swf?audio=secureimage/securimage_play.php&amp;bgColor1=#8E9CB6&amp;bgColor2=#fff&amp;iconColor=#000&amp;roundedCorner=5" id="SecurImage_as3" width="19" height="19" align="middle">--}}
{{--                                                <param name="allowScriptAccess" value="sameDomain" />--}}
{{--                                                <param name="allowFullScreen" value="false" />--}}
{{--                                                <param name="movie" value="secureimage/securimage_play.swf?audio=secureimage/securimage_play.php&amp;bgColor1=#8E9CB6&amp;bgColor2=#fff&amp;iconColor=#000&amp;roundedCorner=5" />--}}
{{--                                                <param name="quality" value="high" />--}}
{{--                                                <param name="bgcolor" value="#ffffff" />--}}
{{--                                            </object>--}}
{{--                                        </noscript>--}}
{{--                                        </p>--}}
{{--                                        <p>--}}
{{--                                            <!-- pass a session id to the query string of the script to prevent ie caching -->--}}
{{--                                            <a tabindex="-1" style="border-style: none" href="#" title="Refresh Image" onClick="document.getElementById('siimage').src = 'secureimage/securimage_show.php?sid=' + Math.random(); return false"><img src="secureimage/images/refresh.gif" alt="Reload Image" border="0" onClick="this.blur()" align="bottom" /></a>--}}
{{--                                            <!--Secure Image Ends-->--}}
{{--                                        </p>--}}
{{--                                    </div>--}}
{{--                                    <div class="code-sec">--}}
{{--                                        <input name="code" type="text" class="form-control" placeholder="Code:" required/>--}}
{{--                                    </div>--}}
                                    <button type="submit" class="btn btn-default">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="contact__map">
                            <h2>Location</h2>
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.8410832793306!2d144.84803755117673!3d-37.817191141913604!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad660e9e904482f%3A0x5352e34420ec5aad!2sU2%2F1%20Millers%20Rd%2C%20Brooklyn%20VIC%203012%2C%20Australia!5e0!3m2!1sen!2snp!4v1618282860037!5m2!1sen!2snp" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
