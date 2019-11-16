define(['jQuery', 'paypal', 'loadingNotification', 'windowLib', 'logservice'], function ($, paypal, notification, windowLib, logservice) {
    var ppegateway = {
        popuped: false,
        redirect: undefined,
        form_id: '#cart-validate-form',

        isLocalError: false, //local website and local script

        filterPaypal400: function (ex) {
            if (ex && ex.message) {
                var f = ex.message.indexOf('{');
                var t = ex.message.lastIndexOf('}');
                var message = ex.message.substring(f, t + 1);
                try {
                    return JSON.parse(message);
                } catch (err) {
                    return false;
                }
            }
            return false;
        },

        postData: function (url, data, headers, async) {
            var pthis = this;
            var returnResult = {
                success: false
            };
            var body = {
                method: "post",
                data: data,
                dataType: "json",
                async: (async ===undefined ? false : async)
            }
            if (headers != undefined) {
                body['headers'] = headers;
            }

            $.ajax(url, body).done(function (data) {
                ppegateway.redirect = data['redirect'];
                returnResult = data;
            }).fail(function (jqXHR) {
                if (jqXHR.responseJSON && jqXHR.responseJSON.errors) {
                    returnResult = {
                        success: 'false',
                        errors: jqXHR.responseJSON.errors
                    };
                } else {
                    returnResult = {
                        success: 'false',
                        errors: ['Unknown system error happened. Please try another payment method. Thanks.']
                    };
                }
            });
            return returnResult;
        },

        prepay: function () {
            return this.postData('/payment/prepay', $(ppegateway.form_id).serialize());
        },

        cancelPay: function () {
            this.popuped = false;
        },

        preparePostPayData: function (paymentData) {
            var formdata = $(ppegateway.form_id).serializeArray();
            for (var i in formdata) {
                var item = formdata[i];
                paymentData[item['name']] = item['value']
            }
            paymentData['_ajax_'] = 1;
            return paymentData;
        }
    };

    window.onbeforeunload = function (e) {
        if (ppegateway.popuped) {
            return "Payment is in processing. If you leave this page, payment will fail.";
        }
    };

    var ppecheckout = {
        init: function (paypalSelector, prepayFormSelector, afterInit, style) {
            var size = $(paypalSelector).attr('data-size');
            if (style == undefined) {
                style = {
                    label: 'checkout',
                    size: size ? size : 'medium',
                    shape: 'rect',
                    color: 'blue',
                    tagline: false
                };
            }
            ppegateway.form_id = prepayFormSelector;
            paypal.Button.render({
                style: style,
                locale: 'en_AU',
                env: paypal_config.env,
                // PayPal Client IDs - replace with your own
                // Create a PayPal app: https://developer.paypal.com/developer/applications/create
                client: paypal_config.client,
                commit: true,
                // payment() is called when the button is clicked
                payment: function (data, actions) {
                    ppegateway.isLocalError = false;
                    if (!windowLib.sendMessage('place-order', 'paypalexpress')) {
                        var rt = new paypal.Promise();
                        rt.rejected = true;
                        rt.error = new Error();
                        ppegateway.isLocalError = true;
                        notification.error('Please fill all required data first.', 3000);
                        return rt;
                    }

                    notification.info('Your payment is in processing. <br>Please do not leave or refresh this page during this process.',
                        10000,
                        function () {
                            if (ppegateway.redirect !== undefined && ppegateway.redirect) {
                                window.location = ppegateway.redirect;
                            }
                        });

                    var prepayData = ppegateway.prepay();
                    if (!prepayData.success) {
                        if (prepayData.message && prepayData.message.body) {
                            notification.error(prepayData.message.body);
                        }
                        var rt = new paypal.Promise();
                        rt.rejected = true;
                        rt.error = new Error("{" + prepayData.message.body + "}");
                        ppegateway.isLocalError = true;
                        notification.error(prepayData.message.body, 3000);
                        return rt;
                    }
                    ppegateway.popuped = true;
                    console.log('prepayData', prepayData.data);
                    // Make a call to the REST api to create the payment
                    var ret = actions.payment.create({
                        payment: prepayData.data.payment
                    });
                    ret.catch(function (e) {
                        var messages = ppegateway.filterPaypal400(e);
                        logservice.collect({
                            source: "paypal",
                            level: 400,
                            cookies: logservice.cookies,
                            messages: messages ? messages : e.message
                        });
                    });
                    return ret;
                },

                // onAuthorize() is called when the buyer approves the payment
                onAuthorize: function (data, actions) {
                    return paypal.request.post('/payment/postpay', ppegateway.preparePostPayData(data))
                        .then(function (result) {
                            ppegateway.popuped = true;
                            if (result.success) {
                                notification.info('Thank you. Your payment has been accepted.<br>Finalizing your order...', 5000, function () {
                                    if (result.redirect !== undefined && result.redirect) {
                                        window.onbeforeunload = null;
                                        window.location = result.redirect;
                                    }
                                });
                            } else {
                                ppegateway.cancelPay();
                                notification.error('Error Happends.', undefined, function () {
                                    if (result.redirect) {
                                        window.onbeforeunload = null;
                                        window.location = result.redirect;
                                    }
                                });
                                if (result.errors) {
                                    for (var i in result.errors) {
                                        notification.append('danger', result.errors[i]);
                                    }
                                }
                            }
                        });
                },
                onCancel: function (data) {
                    ppegateway.cancelPay();
                },
                onError: function (data) {
                    if (ppegateway.isLocalError) {
                        return;
                    }

                    var errorMessage = '';
                    var messages = ppegateway.filterPaypal400(data);
                    if (messages) {
                        errorMessage = 'Error:' + messages.name + '<br>';
                    }

                    errorMessage = errorMessage + 'Payment could not be executed. Please try again or choose other payment method.';
                    ppegateway.popuped = false;
                    ppegateway.cancelPay();
                    notification.error(errorMessage, 0, function () {
                        window.location.reload();
                    });
                }
            }, paypalSelector);

            notification.info('Initialising Paypal...', 2000, function () {
                if (afterInit) {
                    afterInit($);
                }
            });
        }
    };
    return ppecheckout;
});
