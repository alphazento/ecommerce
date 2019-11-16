<?php
    $paymentCode = Inkstation\FatZebra\Services\PaymentMethod::PAYMENT_CODE;
?>

<form id="fatzebra-prepay-form" action="{{ route('payment.prepay') }}">
    {{ Checkout::guid_field() }}
    <input type="hidden" name="quotesnapshotid" value="{{ $quoteSnapshot->getEncryptedId() }}">
</form>

@push('rqjs_configs')
    require_add_config('fatzebraFormLoader', @asset("/tonercitytheme/assets/js/payments/fatzebra-form-loader"), {
        deps: ['jQuery', 'Noty'],
        exports: 'fatzebraFormLoader'
    });
    require_add_config('fatzebraDeviceGenerator', @asset("/tonercitytheme/assets/js/payments/fatzebra-device-generator"), {
        deps: ['jQuery', 'windowLib'],
        exports: 'fatzebraDeviceGenerator'
    });
@endpush
@push('rqjs_body')
    requirejs(['windowLib', 'fatzebraDeviceGenerator'], function(windowLib, fatzebraDeviceGenerator) {
        var useFraudScreening = "{{ $deviceIdScript }}".length > 0;
        var paymentCode = "{{ $paymentCode }}";
        var csrfToken = "{{ csrf_token() }}";
        windowLib.onMessage('payment_method-changed', function(data){
            if (data["to"] !== paymentCode && data["to"] !== '*' ) {
                return;
            }
            if (data['method'] === paymentCode) {
                if (useFraudScreening) {
                    fatzebraDeviceGenerator
                    .init({
                        csrfToken: csrfToken
                    })
                    .run();
                }
                windowLib.lzloadRqjsLib('fatzebraFormLoader', []);
            }
        });

        var initQuote = getGlobalConfigValue('init_quote');
        windowLib.sendMessage("payment_method-changed", {method: initQuote.payment_method, status:"init", to:"fatzebra" });
    });
@endpush

@if($deviceIdScript)
    @push('footer')
    <script src="{{ $deviceIdScript }}"></script>
    @endpush
@endif

@push('footer')
    @include('components.modal-component', [
        'title' => 'Finish your payment',
        'refId' => 'fatzebraIframe',
        'contentTemplate' => 'forms.fatzebra-iframe',
        'fade' => true,
        'center' => true,
    ])
@endpush
