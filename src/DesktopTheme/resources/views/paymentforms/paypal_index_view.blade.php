<?php
    $paymentCode = Inkstation\PaypalExpress\Services\PaypalExpress::PAYMENT_CODE;
?>
@push('rqjs_configs')
    require_add_config("paypal", "https://www.paypalobjects.com/api/checkout", { deps: ['jQuery'], exports: 'paypal' });
    require_add_config("oscpaypal", @asset("/tonercitytheme/assets/js/payments/osc-ppecheckout"), { deps: ['jQuery'], exports: 'oscpaypal' });
    require_add_config('windowLib', @asset("/tonercitytheme/assets/js/windowlib"), {
        deps: [],
        exports: 'windowLib'
    });
@endpush

@push('rqjs_body')
    requirejs(['windowLib'], function(windowLib) {

        var paymentCode = "{{ $paymentCode }}";
        windowLib.onMessage('payment_method-changed', function(data) {
            if (data["to"] !== paymentCode && data["to"] !== '*' ) {
                return;
            }

            if (data['method'] === paymentCode) {
                if (windowLib.lzloadRqjsLib('oscpaypal', ['jQuery'],
                    function($, oscpaypal) {
                        oscpaypal.init('#paypal-button-container', 'form[name="osc__checkout-form"]',
                            function($) {
                                $('#paypal-button-container').show();
                                paypalInitState = 2;
                            }, {
                                label: 'checkout',
                                size: 'large',
                                shape: 'rect',
                                color: 'gold',
                                tagline: false
                            }
                        );
                    }
                )) {
                    $('#paypal-button-container').show();
                }
                windowLib.sendMessage('display-place_order_btn', 'hide');
            } else {
                $('#paypal-button-container').hide();
                windowLib.sendMessage('display-place_order_btn', 'show');
            }
        });
        var initQuote = getGlobalConfigValue('init_quote');
        windowLib.sendMessage("payment_method-changed", {method: initQuote.payment_method, status:"init", to: paymentCode });
    });
@endpush

{{ Checkout::guid_field() }}
<div id="paypal-button-container" style="text-align:center; display: none;"></div>

@push('footer')
    <script>
        var paypal_config = {
            env: "{{ Store::getConfig(Inkstation\PaypalExpress\Constants::ENV_MODE) }}",
            // PayPal Client IDs - replace with your own
            // Create a PayPal app: https://developer.paypal.com/developer/applications/create
            client: {
                sandbox: "{{ Store::getConfig(Inkstation\PaypalExpress\Constants::SANDBOX_CLIENT_ID) }}",
                production: "{{ Store::getConfig(Inkstation\PaypalExpress\Constants::PRODUCTION_CLIENT_ID) }}"
            }
        }
    </script>
@endpush


