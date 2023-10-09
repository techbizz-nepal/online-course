<footer class="footer-site">
    <div class="footer__top">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-xl-6">
                    <div class="courseoffer">
                        <h3>Courses We Offer</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <ul>
                                    @foreach (get_courses() as $course)
                                    @if ($loop->iteration % 2 === 0)
                                        @continue
                                    @endif
                                    <li><a href="{{ route('course', $course) }}">{{ $course->title }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul>
                                    @foreach (get_courses() as $course)
                                        @if ($loop->iteration % 2 !== 0)
                                            @continue
                                        @endif
                                        <li><a href="{{ route('course', $course) }}">{{ $course->title }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <h3>Connect With Us</h3>
                    <div class="connectus">
                        <a href="#"><img src="{{ asset('assets/images/facebook-share.jpg') }}" alt="facebook"></a>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="footer-contact">
                        <h3>Contact Us</h3>
                        <p>Please contat us for all your training courses.</p>
                        <ul>
                            <li class="phone"><a href="tel:0420 774 595">0420 774 595</a></li>
                            <li class="mailto"><a href="mailto:info@key.edu.au">info@key.edu.au</a></li>
                            <li class="location">
                                2/1 Millers Road, Brooklyn VIC 3012<br>
                                ABN: 15 613 868 901<br>
                                RTO No: 45117
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer__copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="copyright">
                        <p>© <a href="#">Knowledge Empowers</a> You All Rights Reserved {{ date('Y') }}.</p>
                    </div>
                </div>
                <div class="col-md-6 text-md-right">
                    <div class="poweredBy">
                        <p><a href="https://www.maxwebsurf.com.au" target="_blank">MaxWebSurf</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
