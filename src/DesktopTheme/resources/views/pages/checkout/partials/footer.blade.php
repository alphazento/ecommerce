@push('styles')
    .sitefooter__sec1{
        background: transparent;
        color: black;
    }
    .sitefooter__sec1:before{
        background: transparent;
        background-color: #E6E6E6;
    }
    .footer-payinfo__title{
        font-size: 12px;
    }
@endpush
<footer class="sitefooter">
    <div class="sitefooter__sec1">
        <div class="container">
            <div class="footer-payinfo">
                <div class="row">
                    <div class="col-md-6 text-center text-lg-left" style="height: 75px;">
                        <div class="row">
                            <div class="col">
                                <strong class="footer-payinfo__title d-none d-lg-inline-block">Secure Payment</strong>
                            </div>
                        </div>
                        <div class="row pt-1">
                            <div class="col">
                                <ul>
                                    <li><img src=@resource('/tonercitytheme/assets/img/payment_methods/mastercard.png') alt="Mastercard" width="49" height="30"></li>
                                    <li class="ml-2"><img src=@resource('/tonercitytheme/assets/img/payment_methods/visa.png') alt="Visa" width="49" height="30"></li>
                                    <li class="ml-2"><img src=@resource('/tonercitytheme/assets/img/payment_methods/pay-pal.png') alt="PayPal" width="49" height="30"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-center text-lg-right" style="height: 75px; line-height: 75px;">
                        <div class="row" style="display: inline-flex; align-items: center">
                            <div style="padding-top: 3px;">
                                <a target="_blank" href="https://www.mcafeesecure.com/verify?host=tonercity.com.au">
                                    <img class="mfes-trustmark" style="border:0;"
                                         src="https://cdn.ywxi.net/meter/tonercity.com.au/102.gif?w=180" width="90" height="37"
                                         title="McAfee SECURE sites help keep you safe from identity theft, credit card fraud, spyware, spam, viruses and online scams"
                                         alt="McAfee SECURE sites help keep you safe from identity theft, credit card fraud, spyware, spam, viruses and online scams"
                                         oncontextmenu="window.open('https://www.mcafeesecure.com/verify?host=tonercity.com.au'); return false;"></a>
                            </div>
                            <div id="eWAYBlock" style="margin-left: 5px;">
                                <div style="text-align:center;">
                                    <a href="https://www.eway.com.au/secure-site-seal?i=13&se=3&theme=0" title="eWAY Payment Gateway" target="_blank" rel="nofollow">
                                        <img alt="eWAY Payment Gateway" width="90" height="37" src="https://www.eway.com.au/developer/payment-code/verified-seal.php?img=13&size=3&theme=0" />
                                    </a>
                                </div>
                            </div>
                            <div style="margin-left: 5px;">
                                <span id="siteseal"><script async type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=RVMab5pJ3N44DPO3lpVanhC6KQ9gN6iahD1xrMbNU5Cb6NhSlYXShpbq45J3"></script></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p class="text-right" style="font-size: 11px;">© {{ date('Y') }} Alphazento. All Rights Reserved</p>
                </div>
            </div>
        </div>
    </div>
</footer>
