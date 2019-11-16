@extends('layouts.3columns')

@section('custom')
    <div class="pagecontent">
        <div class="container">
            <h2>Oops...Our bad.</h2>
            <h2>We couldn't find your page. - {{config('app.domain')}}</h2>
            <p>The page you were looking for could not be found. Yet we have a large range of products you will be
                interested. If this is important, please <a href="/contact-us"><u>contact us</u></a>.</p>
        </div>
    </div>
@endsection
