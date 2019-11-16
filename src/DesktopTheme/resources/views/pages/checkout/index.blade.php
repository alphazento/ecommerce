@extends('layouts.3columns')

@exclude('components.header-nav.main')
@exclude('components.breadcrumb')
@exclude('components.header-nav.minicart', 'components.header-nav.view-cart')
@exclude('components.footer')

@push('head')
    <link rel="stylesheet" href=@asset("/tonercitytheme/assets/css/checkout.css")>
    <link rel="stylesheet" href=@asset("/tonercitytheme/assets/css/product.css")>
    <link rel="stylesheet" href=@asset("/tonercitytheme/assets/css/noty.css")>
    <link rel="stylesheet" href=@asset("/tonercitytheme/assets/css/metroui.css")>
    <link rel="stylesheet" href=@resource("/fatzebra/css/stylesheet.css")>
@endpush

@push('styles')
    #waiting-verify-to-placeorder{
        color: rgba(0, 0, 0, .54);
        cursor: pointer;
        height: 30px;
        width: 30px;
        z-index: 10;
        display: none;
    }

    #processing-text{
        color: rgba(0, 0, 0, .54);
        cursor: pointer;
        height: 30px;
        width: 30px;
        z-index: 10;
        display: none;
    }
@endpush

@section('custom')
    <div class="container">
        <div class="clearfix row">
            <div class="col-sm-4">
                <a class="logo" href="{{route('home')}}">
                    <img class="logo-big" src=@asset("/tonercitytheme/assets/img/logo.png") alt="Alphazento">
                </a>
            </div>
            <div class="col-sm-4 text-center osc__title">
                <h4>CHECKOUT</h4>
            </div>
            <div class="col-sm-4"></div>
        </div>
        <div class="row pt-1">
            <hr class="osc__title-line">
        </div>
        <div class="row">
            <div class="col-sm-4">
                <a class="osc__back__cart" href="{{ route('cart') }}"><i class="fa fa-chevron-left"></i>&nbsp;<span class="osc__font__bold">Back to Cart</span></a>
            </div>
            <div class="col-sm-4 text-center">
                <p class="osc__font__bold">Please fill in the following information for checkout</p>
            </div>
            <div class="col-sm-4"></div>
        </div>
        <div class="one-step-checkout osc">
            <div class="row mt-4">
                <div class="col-sm-4 mb-4">
                    @includeWhen(!Auth::isFullLogin(), 'pages.checkout.partials.guest-detail-management')
                    @includeWhen(Auth::isFullLogin(), 'pages.checkout.partials.authed-address-management', ['formId' => 'formid'])
                </div>
                <div class="col-sm-4">
                    <div class="osc__block mb-4">
                        <div class="osc__head">
                            <h4 class="osc__h4">2. PAYMENT METHOD</h4>
                        </div>
                        <div class="osc__body p-3">
                            @include('pages.checkout.partials.payment-methods')
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="osc__block mb-2 orderreview-iframe-block">
                        <div class="osc__head">
                            <h4 class="osc__h4">3. ORDER REVIEW</h4>
                        </div>
                        <div class="osc__body p-3 pb-0">
                            <div id="cart-table-view">
                                @include('pages.checkout.partials.cart-table')
                            </div>
                        </div>
                        <div class="osc__body">
                            <div id="order-summary-view">
                                @include('pages.checkout.partials.order-summary')
                            </div>
                        </div>
                    </div>

                    @include('pages.checkout.partials.coupon-and-comment')
                    <div class="text-center">
                        <span id="waiting-verify-to-placeorder"><i class="fa fa-spinner fa-pulse fa-2x"></i></span>
                    </div>
                    <div class="text-center">
                        <span id="processing-text"><i class="fa fa-spinner fa-pulse fa-lg"></i> Processing...</span>
                    </div>
                    <form name="osc__checkout-form">
                        <input type="hidden" name="action" value="process">
                        <input type="hidden" name="quotesnapshotid" value="{{$quoteSnapshot->getEncryptedId()}}">
                        <div class="osc__checkout-place-order-btn-container" onclick="reloadIfJsErr()">
                            <button class="tc__btn-green btn--green place-order-btn placeorder" type="button" id="tc__theme-button">PLACE ORDER NOW</button>
                        </div>
                        @foreach($paymentMethods as $paymentMethod)
                            {!! $paymentMethod->renderIndexView() !!}
                        @endforeach
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-footer')
    @include('pages.checkout.partials.footer')
@endsection

@push('rqjs_configs')
    require_add_config('Noty', @asset("/tonercitytheme/assets/js/noty.min"), {
        deps: [],
        exports: 'Noty'
    });

    //when place order button click, check if requirejs is correct, if not, reload
    function reloadIfJsErr() {
        if (requirejs_err) {
            window.location.reload();
        }
    }
@endpush

@push('rqjs_body')
setGlobalConfigKeyValue('init_quote', @json($quoteSnapshot));

requirejs(['jQuery', 'windowLib', 'loadingNotification'], function($, windowLib, notifier) {
    var quote = getGlobalConfigValue('init_quote');
    var currentMethod = quote.payment_method;
    var $placeOrderBtn = $('.osc__checkout-place-order-btn-container');
    var $processingText = $('#processing-text');
    @if(Auth::isFullLogin())
        var authModes = ['full'];
    @else
        var authModes = ['half', 'guest'];
    @endif

    var setPaymentMethod = function(method, status, depressHideNotifier) {
        depressHideNotifier = depressHideNotifier || false;
        currentMethod = method;
        $('form[name=osc__checkout-form] > input[name=payment_method]').val(currentMethod);
        if (status !== 'init') {
            $.ajaxPUT('/ajax/quote/payment-method/' + currentMethod, {}, function(data) {
                windowLib.sendMessage('osc-ajax-responsed', data);
                return depressHideNotifier;
            });
        }
    }

    windowLib
    .onMessage('osc-ajax-responsed', function(data) {
        if (authModes.indexOf(data['authstate']) === -1) {
            window.location.reload();
        }
        if (data['redirect']) {
            window.location.href = data['redirect'];
        }
        if (data['success']) {
            if (data['data'].hasOwnProperty('quoteSnapshot')) {
                quote = data['data']['quoteSnapshot'];
            } else {
                window.location.reload();
            }
        } else {
            notifier.error(data['message']['body']);
        }
        windowLib.sendMessage('quote-updated', quote);
    })
    .onMessage('payment_method-changed', function(data) {
        setPaymentMethod(data['method'], data['status']);
    })
    .onMessage('set-payment_method', function(method) {
        setPaymentMethod(method, 'syncdata', true);
    })
    .onMessage('display-place_order_btn', function(status) {
        if (status === 'hide') {
            $('.osc__checkout-place-order-btn-container').hide();
        } else {
            $('.osc__checkout-place-order-btn-container').show();
        }
    })
    .onMessage('pre-cancel-placing-order', function(data) {
        $placeOrderBtn.show();
        $processingText.hide();
    })
    .onMessage('pre-place-order-error', function(data) {
        notifier.error(data['error'], 1500);
        if (!$('#paypal-button-container').is(':visible')) {
            $placeOrderBtn.show();
        }
        $processingText.hide();
    });

    $('.osc__checkout-place-order-btn-container').click(function() {
        $placeOrderBtn.hide();
        $processingText.show();
        var comment = $('#comment').val();
        var successful = true;
        if(comment !== ''){
            $.ajaxSync(true).ajaxPUT('/ajax/quote/comment', {comment: comment}, function(data){
                if(!data['success']){
                    $('.osc__comment-fail').html(data['message']['body']).show();
                    successful = false;
                }
            });
        }
        if(successful === true){
            notifier.info('Placing order...');
            windowLib.sendMessage('place-order', currentMethod);
        }
    });

    $.ajaxSetup({ headers: { 'X-QT-SSID': "{{$quoteSnapshot->getEncryptedId()}}" } });

    $('#comment').blur(function(){
        var comment = $(this).val();
        if(currentMethod == 'paypalexpress' && comment !== ''){
            $.ajaxSync(true).ajaxPUT('/ajax/quote/comment', {comment: comment}, function(data){
                if(!data['success']){
                    $('.osc__comment-fail').html(data['message']['body']).show();
                }
            });
        }
    });
});
@endpush

@push('footer')
    @includeWhen(!Auth::isFullLogin(), 'pages.checkout.partials.modals.sign-in-modal')
    @includeWhen(!Auth::isFullLogin(), 'pages.checkout.partials.modals.forgot-password-modal')
    @includeWhen(!Auth::isFullLogin(), 'pages.checkout.partials.modals.forgot-password-email-sent-modal')
@endpush
