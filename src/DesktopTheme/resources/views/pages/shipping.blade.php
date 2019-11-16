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
            <h2 class="widget-title">Delivery charges</h2>
            <p>Free delivery is included for purchase total over $50, otherwise standard flat rate delivery charge of $6.95 will apply. Certain items may have promotional free shipping included, so please look out for the free shipping logo attached to those promotional pack deals. We also do not charge any handling fees, so there are no other hidden costs involved when purchasing from us.</p>

            <p>Please ensure delivery address details are entered correctly, once goods have been dispatched from our warehouse we are not responsible for incorrect address delivery. Incorrect or insufficient delivery address will incur a re-delivery fee.</p>
        </div>
    </section>
    <section>
        <div class="container">
            <h2 class="widget-title">Shipping methods</h2>
            <p>Our dispatch team will choose a suitable, reliable and fastest delivery method to cater for your location. All orders will be delivered by either Express post, registered post or a courier service. This will be decided by the dispatch team accordingly. Should you have specific delivery instructions or requests, please do not hesitate to contact our customer service team for assistance.</p>

            <p>Please note that overseas orders will NOT be accepted, our delivery service is within Australia only. Our business does not have a shop front, so direct pick up in person is NOT available. Hence all orders are dispatched directly from our warehouses.</p>
        </div>
    </section>
    <section>
        <div class="container">
            <h2 class="widget-title">Dispatch time</h2>
            <p>All orders placed before 3:00pm (AEST) between Monday to Friday will be dispatched the same business working day, unless out of stock. For any orders placed after 3:00pm (AEST) on a Friday and orders on weekends or public holidays will mean that the order will be dispatched on the next business day.</p>

            <p>On the occasion where we are out of stock on certain items due to reasons beyond our control, our customer service team will be in contact with you to provide you with either an update or other available options. Where appropriate, we may dispatch your order directly from our suppliers to fulfill your order.</p>
        </div>
    </section>
    <section>
        <div class="container mb-5">
            <h2 class="widget-title">Delivery estimate</h2>
            <p>Delivery times may vary depending on the shipping method used and the delivery address you have provided. As a general guide, once the order has been dispatched from our warehouse location, deliveries to major cities will take 1 to 2 business working days. For deliveries to the more remote areas, it could take up to 5 business working days.</p>
        </div>
    </section>
@endsection
