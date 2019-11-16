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
            <p>Tonercity is proud to be a 100% Australian owned and operated company.</p>

            <p>We stock an extensive range of genuine OEM, compatible and remanufactured inkjet and toner cartridges. Our supply includes major genuine OEM brands such as Canon, Brother, HP, Epson, Samsung, Lexmark, Oki, Kyocera and Xerox.</p>

            <p>We have spent considerable time and effort to source the best quality compatible toner cartridges & inkjet cartridges with highly strict quality control. We have over 10 years industry experience in the print cartridge market and our buying power enables us to offer you the best quality ink cartridges at the lowest price. Where possible, we can even price match to maintain our competitiveness in the market. Please speak directly to our friendly team members for further info.</p>

            <p>All of our prices are in Australian dollars (AUD) and include GST (Goods and Services Tax)</p>
        </div>
    </section>
    <section>
        <div class="container">
            <h2 class="widget-title">Here's why TonerCity stands out from the crowd</h2>
            <ul class="list-icon">
                <li>Order with ease and convenience any time you like</li>
                <li>Quick delivery turn-around.</li>
                <li>Competitive pricing</li>
                <li>Our compatible products are manufactured under ISO9001 quality standards</li>
                <li>1 Year warranty on our compatible range or manufacturer's warranty for OEMs</li>
                <li>Safe and secure shopping.</li>
            </ul>
        </div>
    </section>
@endsection
