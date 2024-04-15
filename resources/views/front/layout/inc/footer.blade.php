<footer class="footer">
    <div class="footer-area">
        <div class="container">
            <div class="row section_gap">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="single-footer-widget tp_widgets">
                        <h4 class="footer_title large_title">Our Mission</h4>
                        <p>{{ get_settings()->site_meta_description }}</p>
                        <p>
                            So seed seed green that winged cattle in. Gathering thing made fly you're no divided deep moved 
                        </p>
                    </div>
                </div>

                <div class="offset-lg-1 col-lg-2 col-md-6 col-sm-6">
    <div class="single-footer-widget tp_widgets">
        <h4 class="footer_title">Stay connected</h4>
        <ul>
            <li>
                <a href="{{ get_social_network()->facebook_url }}" target="_blank">
                    <i class="fab fa-facebook-f fa-3x"></i>
                </a>
            </li>
            <li>
                <a href="{{ get_social_network()->twitter_url }}" target="_blank">
                    <i class="fab fa-twitter fa-3x"></i>
                </a>
            </li>
            <li>
                <a href="{{ get_social_network()->instagram_url }}" target="_blank">
                    <i class="fab fa-instagram fa-3x"></i>
                </a>
            </li>
            <li>
                <a href="{{ get_social_network()->linkedin_url }}" target="_blank">
                    <i class="fab fa-linkedin fa-3x"></i>
                </a>
            </li>
        </ul>
    </div>
</div>

                
                
                

                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="single-footer-widget instafeed">
                        <h4 class="footer_title">Category</h4>
                        <ul class="list">
                            <li><a href="#">Men</a></li>
                            <li><a href="#">Women</a></li>
                            <li><a href="#">Kids</a></li>
                            <li><a href="#">Accessories</a></li>
                            <li><a href="#">Equipment </a></li>
                            <li><a href="#">Brands</a></li>
                        </ul>
                    </div>
                </div>
                <div class="offset-lg-1 col-lg-3 col-md-6 col-sm-6">
                    <div class="single-footer-widget tp_widgets">
                        <h4 class="footer_title">Contact Us</h4>
                        <div class="ml-40">
                            <p class="sm-head">
                                <span class="fa fa-location-arrow"></span>
                                Head Office
                            </p>
                            <i data-feather="home"></i>
                            <a href="http://maps.google.com/maps?q=<?=
                            urlencode(get_settings()->site_address) ?>"
                            target="_blank">{{ get_settings()
                            ->site_address }}</a>

                            <p class="sm-head">
                                <span class="fa fa-phone"></span>
                                Phone Number
                            </p>
                            <p> {{get_settings()->site_phone }} </p>

                            <p class="sm-head">
                                <span class="fa fa-envelope"></span>
                                Email
                            </p>
                            <i data-feather="mail"></i>
                            <a href="mailto:{{ get_settings()->site_email }}
                            ">{{ get_settings()->site_email }}</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row d-flex">
                <p class="col-lg-12 footer-text text-center">
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
            </div>
        </div>
    </div>
</footer>