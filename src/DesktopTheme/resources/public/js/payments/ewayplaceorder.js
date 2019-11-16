define(['jQuery', 'ewaytransparent', 'ccvalidator', 'loadingNotification', 'windowLib'],
    function ($, ewaytransparent, ccvalidator, modal, windowLib) {
        'use strict';
        $.ccvalidator.init();
        $.ewaytransparent.init($('#checkout__eway-prepay-form'), $('#checkout__eway-form'));

        windowLib.onMessage('pre-place-order', function (method) {
            if (method !== 'eway') {
                return;
            }

            if (!$.ewaytransparent.canCapture()) {
                return true;
            }
        });

        windowLib.onMessage('place-order', function (method) {
            if (method !== 'eway') {
                return;
            }

            modal.info('Your payment is in processing. <br>Please do not leave or refresh this page during this process.');
            $.ewaytransparent.capture(function (success, eway, data, status) {
                if (success) {
                    if (data.success) {
                        if (data.access_code) {
                            eway.transparentSubmit();
                        }
                    } else {
                        $.ewaytransparent.redirect = data.redirect;
                        modal.error(data.errors.join(' '), 5000, function () {
                            if ($.ewaytransparent.redirect !== undefined && $.ewaytransparent.redirect) {
                                window.location = $.ewaytransparent.redirect;
                            }
                        });
                    }
                } else {
                    if (status == 401) {
                        window.location = window.location;
                        return;
                    }
                    if (data.errors) {
                        modal.error(data.errors.join(' '), 2000, function () {
                            window.location = window.location;
                        });
                    }
                }
            });
        });
    }
);
