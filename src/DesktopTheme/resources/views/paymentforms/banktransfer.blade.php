<div id="bank_transfer-block" class="fullwidth infoBox infoBoxContents4" style="padding:5px 15px;display:none; font-size: 14px;">
    You have selected to pay with bank transfer. Bank details will be provided after your order confirmation. <br>
    <strong>Note:</strong> All payments must be received in full before the order is dispatched. This normally takes 1-2 business days.
</div>

@push('rqjs_body')
    requirejs(['jQuery', 'windowLib'], function($, windowLib) {
        windowLib.onMessage('payment_method-changed', function(data) {
            if (data["to"] !== 'bank_transfer' && data["to"] !== '*' ) {
                return;
            }
            if (data['method'] === 'bank_transfer') {
                $('#bank_transfer-block').show();
            } else {
                $('#bank_transfer-block').hide();
            }
        }).onMessage('place-order', function(method){
            if ('bank_transfer' === method) {
                var $form = $('form[name=osc__checkout-form]');
                $form.attr('action', '/payment/postpay');
                $form.attr('method', 'POST');
                $form.submit();
            }
        });

        var initQuote = getGlobalConfigValue('init_quote');
        windowLib.sendMessage("payment_method-changed", {method: initQuote.payment_method, status:"init", to:"bank_transfer" });
    });
@endpush
