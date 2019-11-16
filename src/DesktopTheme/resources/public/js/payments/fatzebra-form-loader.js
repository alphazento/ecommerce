define(['jQuery', 'Noty', 'windowLib'], function ($, Noty, windowLib) {
    return (function () {
        windowLib.onMessage('place-order', function (method) {
            if (method !== 'fatzebra') {
                return;
            }
            var $form = $('#fatzebra-prepay-form');
            var data = $form.serialize();
            var url = $form.attr('action');
            $.ajaxPOST($form.attr('action'), data, function (response) {
                $('#fatzebra-payment').html(response.data.iframe);
                $('#fatzebra-order-total').text('Amount: $' + (response.data.total / 100).toFixed(2));
                $('#fatzebraIframe').modal();
            }, function (xhr) {
                var response = xhr.responseJSON;
                new Noty({
                    theme: 'metroui',
                    type: response.message.type,
                    text: response.message.body,
                    timeout: 4000,
                }).show();
            });
        });
    })();
});
