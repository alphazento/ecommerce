@extends('layouts.3columns')

@push('styles')
    .widget-title {
        font-weight: 300;
        line-height: 1.1;
        font-size: 1.6rem;
        margin-top: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .list-icon {
        list-style: outside none none;
        margin-top: 0rem;
        margin-bottom: 2.5rem;
    }

    .list-icon > li {
        margin-top: 0rem;
        margin-bottom: 0.5rem;
    }
@endpush

@section('custom')
    <section>
        <div class="container">
            <h2 class="widget-title">Secure Shopping</h2>
            <p>TonerCity uses 128-bit Secure Sockets Layer (SSL) software. This technology is widely used by online retailers to securely protect personal details for online commerce transactions. This means your personal details, credentials, and payment information is safely encrypted over the internet to our system. Look for the little green padlock that appears next to the website’s address on your browser.</p>
        </div>
    </section>
    <section>
        <div class="container mb-5">
            <h2 class="widget-title">Paying Securely Online</h2>
            <p>TonerCity partners with eWAY to handle the online payment gateway services involving the use of credit card payments. Credit card details are securely handled on eWay’s systems -  TonerCity cannot in any way access or store your card details (including credit card number, CCV and PIN number).</p>

            <p>For more information on eWAY and its online security infrastructure, please visit the <a href="https://www.eway.com.au/about-eway/technology-security/">eWAY website.</a></p>

            <p>TonerCity also offers secure payments with PayPal. PayPal is a popular online secure payment service that protect both the customer and the merchant from security threats to payment accounts and credit card details.</p>

            <p>For more information on PayPal, please visit the <a href="https://www.paypal.com/au/webapps/mpp/home">PayPal website</a>.</p>
        </div>
    </section>
@endsection
