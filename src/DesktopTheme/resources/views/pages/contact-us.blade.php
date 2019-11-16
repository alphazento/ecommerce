@extends('layouts.3columns')

@section('custom')

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                @include('forms.contact-us-form')
                </div>

                <div class="col-sm-6">
                    <div>
                        <div>
                            <span style="font-size: 20px;"><i class="fa fa-map-marker"></i> Address</span>
                            <p>Alphazento, PO BOX 129, Hurstville BC, NSW 1460</p>
                        </div>
                        <hr>

                        <div>
                            <span style="font-size: 20px;"><i class="fa fa-phone"></i> Call Us</span>
                            <p><a href="tel:1300330242" target="_blank">1300 330 242</a></p>
                        </div>
                        <hr>
                        <div>
                            <span style="font-size: 20px;"><i class="fa fa-envelope"></i> Email Us</span>
                            <p><a href="mailto:i:sales@tonercity.com.au" target="_blank">sales@tonercity.com.au</a></p>
                        </div>
                        <hr>
                        <div>
                            <span style="font-size: 20px;"><i class="fa fa-clock-o"></i> Office Hours</span>
                            <p>9am To 5pm AEST</p>
                        </div>
                        <hr>
                        <div>
                            <span style="font-size: 20px;"> <i class="fa fa-building"></i> Company</span>
                            <p>Alphazento</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
