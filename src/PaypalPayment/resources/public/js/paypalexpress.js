(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define(factory);
    } else if (typeof exports === 'object') {
        module.exports = factory();
    } else {
        var oldpaypalexpress = window.paypalexpress;
        var paypalexpress = window.paypalexpress = factory();
        paypalexpress.noConflict = function () {
            window.paypalexpress = oldpaypalexpress;
            return paypalexpress;
        };
    }
}(function () {
    var paypalexpress = {
        init: function (reactPaymentComponent, client, extraParams, paypalSelector) {
            console.log('paypal init', extraParams, paypalSelector);
            this.reactPaymentComponent = reactPaymentComponent;
            window.paypal.Button.render({
                    style: {
                        label: 'checkout',
                        size: 'medium',
                        shape: 'rect',
                        color: 'gold',
                        tagline: false
                    },
                    locale: 'en_AU',
                    env: window.paypal_config.env,
                    // PayPal Client IDs - replace with your own
                    // Create a PayPal app: https://developer.paypal.com/developer/applications/create
                    client: window.paypal_config.client,
                    commit: true,
                    // payment() is called when the button is clicked
                    payment: function (data, actions) {
                        if (reactPaymentComponent) {
                            console.log('tony', 'req');
                            let rq = new Promise(function (resolve, reject) {
                                console.log('tony', 'rq', extraParams);
                                client.post(extraParams["prepare_endpoint"], data).then(resp => {
                                    console.log('tony', 'resp', extraParams);
                                    if (resp.status === 200) {
                                        var ret = actions.payment.create({
                                            payment: resp.data
                                        });
                                        ret.catch(function (e) {
                                            var messages = paypalexpress.filterPaypal400(e);
                                            console.log('paypal error', message, e);
                                            // logservice.collect({
                                            //     source: "paypal",
                                            //     level: 400,
                                            //     cookies: logservice.cookies,
                                            //     messages: messages ? messages : e.message
                                            // });
                                        });
                                        console.log('tony', 'resolve');
                                        resolve(ret);
                                    }
                                });
                            });
                            var pro = Promise.all([rq]).then(resp => {
                                console.log('tony', resp);
                            });
                            console.log('tony return');
                            return pro;
                        }
                    },

                    // onAuthorize() is called when the buyer approves the payment
                    onAuthorize: function (data, actions) {
                        return window.paypal.request.post('/payment/postpay', data)
                            .then(resp => {
                                if (resp.success) {
                                    //redirect to success.
                                    console.log('paypal success, redirecting');
                                } else {
                                    paypalexpress.cancelPay();
                                    if (resp.errors) {
                                        console.log('paypal error');
                                    }
                                }
                            });
                    },
                    onCancel: function (data) {
                        paypalexpress.cancelPay();
                    },
                    onError: function (data) {
                        var errorMessage = '';
                        var messages = ppegateway.filterPaypal400(data);
                        if (messages) {
                            errorMessage = 'Error:' + messages.name + '<br>';
                        }

                        errorMessage = errorMessage + 'Payment could not be executed. Please try again or choose other payment method.';

                        console.log('paypal error', errorMessage)
                    }
                },
                paypalSelector);
        },

        preCapture: function (cart_data) {
            return this.client.post('/payment/presubmit', cart_data);
        },

        capture: function () {

        },

        placeOrder: function () {
            if (this.reactPaymentComponent) {
                this.client.post(this.extraParams["prepare_endpoint"]).then(resp => {
                    if (resp.status === 200) {

                    }
                });
            }
        }
    };
    return paypalexpress;
}));