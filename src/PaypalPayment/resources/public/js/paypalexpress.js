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
                        var ret = actions.payment.create({
                            payment: reactPaymentComponent.prepare()
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
                        return ret;
                    },

                    // onAuthorize() is called when the buyer approves the payment
                    onAuthorize: function (data, actions) {
                        return window.paypal.request.post(extraParams['submit_endpoint'], data)
                            .then(resp => {
                                if (resp.success) {
                                    //redirect to success.
                                    console.log('paypal success, redirecting');
                                } else {
                                    // paypalexpress.cancelPay();
                                    if (resp.errors) {
                                        console.log('paypal error');
                                    }
                                }
                            });
                    },
                    onCancel: function (data) {
                        // paypalexpress.cancelPay();
                    },
                    onError: function (data) {
                        var errorMessage = '';
                        var messages = paypalexpress.filterPaypal400(data);
                        if (messages) {
                            errorMessage = 'Error:' + messages.name + '<br>';
                        }

                        errorMessage = errorMessage + 'Payment could not be executed. Please try again or choose other payment method.';

                        console.log('paypal error', errorMessage)
                    }
                },
                paypalSelector);
        },

        preCapture: function (cart) {
            var items = [];
            cart.items.forEach(item => {
                items.push({
                    name: item.name,
                    description: item.description,
                    quantity: item.quantity,
                    price: item.unit_price,
                    sku: item.id,
                    currency: "AUD"
                })
            })
            var payment = {
                intent: "sale",
                payer: {
                    payer_info: {
                        email: cart.email
                    }
                },
                transactions: [{
                    amount: {
                        total: cart.total,
                        currency: "AUD",
                        details: {
                            subtotal: cart.subtotal,
                            shipping: cart.shipping_fee
                        }
                    },
                    description: "The payment transaction description.",
                    custom: cart.customer_id,
                    invoice_number: "c" + cart.customer_id + cart.guid,
                    payment_options: {
                        allowed_payment_method: "UNRESTRICTED"
                    },
                    item_list: {
                        items: items,
                        shipping_address: {
                            recipient_name: cart.shipping_address.firstname + ' ' + cart.shipping_address.lastname,
                            line1: cart.shipping_address.address1,
                            line2: cart.shipping_address.address2,
                            city: cart.shipping_address.city,
                            country_code: "AU",
                            postal_code: 2000,
                            state: "NSW"
                        }
                    }
                }]
            }
            return payment;
        },

        placeOrder: function () {
            throw new "Paypal should not call function placeOrder";
        }
    };
    return paypalexpress;
}));