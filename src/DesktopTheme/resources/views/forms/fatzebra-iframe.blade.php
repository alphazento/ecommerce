<div id="fatzebra-order-total" class="text-center font-weight-bold"></div>
<div id="fatzebra-payment" style="background-color: #fff;"></div>
@push('rqjs_body')
requirejs(['jQuery', 'windowLib'], function($, windowLib) {
    $(document).on('hide.bs.modal', '#fatzebraIframe', function() {
        console.log('closing fatzebra form');
        $('.osc__checkout-place-order-btn-container').show();
        $('#processing-text').hide();
    });
});
@endpush
