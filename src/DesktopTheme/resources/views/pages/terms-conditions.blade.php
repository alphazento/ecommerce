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
        list-style-type: square;
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
        <p>Welcome to Tonercity.com.au (hereinafter "TonerCity," "Company" or "Site"). By using the Site and placing an order, you are agreeing to our Terms and Conditions. In addition, you also agree to comply with any rules or guidelines posted on the Site regarding any of the goods or services offered. TonerCity reserves the right to amend or update these Terms and Condition, rules, and guidelines at any time without prior notice to you. Your continued use of our website following any such amendments will be deemed to be confirmation that you accept those amendments.</p>
        <h2 class="widget-title">Use of the Site</h2>
        <ul class="list-icon">
            <li>You agree not to access (or attempt to access) the Site by means other than through the interface that is provided by TonerCity.</li>

            <li>You agree that you will not engage in any activity that interferes with or disrupts the Site (or the servers and networks which are connected to the Site). Furthermore, you may not mirror any of the content from this Site on another website or in any other media.</li>

            <li>Your use of any information or materials on this Site is entirely at your own risk, for which we shall not be liable. It shall be your own responsibility to ensure that any products, services or information available through this Site meet your specific requirements.</li>

            <li>You agree that you will not use, nor will you allow or authorise any third party to use the Site for any purpose that is unlawful, defamatory, harassing, abusive, fraudulent, obscene or in any other inappropriate way which conflicts with TonerCity.</li>

            <li>Unauthorised use of this Site may be a criminal offence and/or give rise to a claim for damages.</li>

            <li>Every effort is made to keep the website up and running smoothly. However, we take no responsibility for, and will not be liable for, the Site being temporarily unavailable due to technical issues beyond our control.</li>
        </ul>
    </div>
</section>
<section>
    <div class="container">
        <h2 class="widget-title">Intellectual Property and Copyrights</h2>
        <ul class="list-icon">
            <li>TonerCity contains material which is owned by or licensed to us. This material includes, but is not limited to, the content, design, layout, appearance, look and graphics of the Site. Any reproduction of the Site’s material is prohibited other than in accordance with the Copyright Act, which forms part of these terms and conditions. Specifically, you must not use or replicate our copyright material for commercial purposes unless expressly agreed to by us.</li>

            <li>All trademarks reproduced by TonerCity, which are not the property of, or licensed to us, are acknowledged on the Site.</li>
        </ul>
    </div>
</section>
<section>
    <div class="container">
        <h2 class="widget-title">Governing Law</h2>
        <ul class="list-icon">
            <li>These Terms and Conditions are governed by and construed in accordance with the laws of Australia and the State of New South Wales.  Any disputes concerning this Site shall be subject to the exclusive jurisdiction of the state and federal courts located in the State of New South Wales.</li>
        </ul>
    </div>
</section>
<section>
    <div class="container mb-5">
        <h2 class="widget-title">Privacy</h2>
        <ul class="list-icon">
            <li>Use of information you have provided us with, or that we have collected and retained relating to your use of the TonerCity and/or our Services, is governed by our Privacy Policy.  By using this Site, you are agreeing to the Privacy Policy.  To view our Privacy Policy and to read more about why we collect personal information from you and how we use that information, <a href="{{route('privacy')}}">click here.</a></li>
        </ul>
    </div>
</section>
<section>
    <div class="container">
        <h2 class="widget-title">Indemnity</h2>
        <ul class="list-icon">
            <li>You indemnify us from and against all claims, suits, demands, actions, liabilities, costs and expenses (including legal costs and expenses on a full indemnity basis) resulting from your use of the TonerCity’s website. In no event will we be liable for any loss, damage, cost or expense including legal costs and expenses (whether direct or indirect) incurred by you in connection with the use of this Site.</li>
        </ul>
    </div>
</section>
<section>
    <div class="container">
        <p class="mb-5">If you breach these Terms and Conditions, we reserve the right to refuse or terminate service to anyone at any time without notice or reason.</p>
    </div>
</section>
@endsection
