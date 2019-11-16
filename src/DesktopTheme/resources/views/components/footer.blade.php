<footer class="sitefooter">
    <div class="sitefooter__sec1">
        <div class="container">
            <div class="row">
                <div class="col-md-3 d-none d-md-block">
                    <div class="footer-links">
                        <h3 class="footer-title">Company</h3>
                        <ul>
                            <li><a href="{{ route('about-us') }}">About Us</a></li>
                            <li><a href="https://www.tonercity.com.au/blog">Blog</a></li>
                            <li><a href="{{ route('conditions') }}">Secure Order Online</a></li>
                            <li><a href="{{ route('shipping') }}">Shipping</a></li>
                            <li><a href="{{ route('returns') }}">Returns</a></li>
                            <li><a href="{{ url('contact-us') }}">Contact Us</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-12 col-md-3 order-md-1">
                    <div class="footer-links footer-social">
                        <h3 class="footer-title">Follow Us</h3>
                        <ul class="footer-social-links">
                            <li><a href="https://www.facebook.com/tonercity.com.au"><i class="sicon sicon-fb"></i> Facebook</a></li>
                            <li><a href="https://plus.google.com/109045058075920260488"><i class="sicon sicon-gp"></i> Google Plus</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="footer-seperater"></div>

            <div class="footer-payinfo">
                <div class="row">
                    <div class="col-md-6 text-center text-lg-left">
                        <strong class="footer-payinfo__title d-none d-lg-inline-block">Payment Methods</strong>
                        <ul>
                            <li><img src=@resource('/tonercitytheme/assets/img/payment_methods/mastercard.png') alt="Mastercard" width="49" height="30"></li>
                            <li><img src=@resource('/tonercitytheme/assets/img/payment_methods/visa.png') alt="Visa" width="49" height="30"></li>
                            <li><img src=@resource('/tonercitytheme/assets/img/payment_methods/pay-pal.png') alt="PayPal" width="49" height="30"></li>
                        </ul>
                    </div>
                    <div class="col-md-6 text-center text-lg-right">
                        <strong class="footer-payinfo__title d-none d-lg-inline-block">Payment Security</strong>
                        <ul>
                            <li><img src=@resource('/tonercitytheme/assets/img/payment_security/logo-geotrust.png') alt="Geotrust" width="95" height="30"></li>
                            <li><img src=@resource('/tonercitytheme/assets/img/payment_security/logo-eway-secure.png') alt="Eway-secure" width="96" height="30"></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="sitefooter__sec2">
        <div class="container">
            <div class="footer-links sub-nav">
                <ul>
                    <li>© {{ date('Y') }} Alphazento. All Rights Reserved</li>
                    <li><a href="{{route('terms-conditions')}}">Terms &amp; Conditions</a></li>
                    <li><a href="{{route('privacy')}}">Privacy</a></li>
                </ul>
            </div>

            <div class="terms-condition">
                <p>Brother, Hewlett Packard, Lexmark, Canon, Epson, Kyocera, Samsung, Fuji Xerox and other manufacturer
                    brand names and product logos are used solely for purposes of demonstrating compatibility. All
                    Trademarks referenced are property of their respective holders. TonerCity has no affiliation with
                    any manufacturer or OEM and nor has any arrangement been made with them to form the basis for any
                    statement we make. Any and all use of brand name or model descriptions is made solely for purposes
                    of demonstrating compatibility. Please note that due to the high volume of items listed on this
                    website, there may be times when item names or descriptions vary from the product ordered.
                </p>
            </div>

            <div>
                <a target="_blank" href="https://www.mcafeesecure.com/verify?host=tonercity.com.au">
                    <img class="mfes-trustmark" style="border:0;"
                         src="https://cdn.ywxi.net/meter/tonercity.com.au/102.gif?w=180" width="90" height="37"
                         title="McAfee SECURE sites help keep you safe from identity theft, credit card fraud, spyware, spam, viruses and online scams"
                         alt="McAfee SECURE sites help keep you safe from identity theft, credit card fraud, spyware, spam, viruses and online scams"
                         oncontextmenu="window.open('https://www.mcafeesecure.com/verify?host=tonercity.com.au'); return false;"></a>
            </div>
        </div>
    </div>
</footer>
