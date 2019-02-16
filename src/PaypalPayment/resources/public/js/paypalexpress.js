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
        findPaypal400Error: function (ex) {
            if (ex && ex.message) {
                var f = ex.message.indexOf('{');
                var t = ex.message.lastIndexOf('}');
                var message = ex.message.substring(f, t + 1);
                return JSON.parse(message);
            }
            return false;
        },

        init: function (reactPayment, client, extraParams, paypalSelector) {
            console.log('paypal init', extraParams, paypalSelector);
            this.reactPayment = reactPayment;
            this.client = client;
            this.extraParams = extraParams;
            this.paypalSelector = paypalSelector;
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
                        console.log('tony prepaerPayment', window.paypal_config, reactPayment, actions)
                        var ret = actions.payment.create({
                            payment: reactPayment.prepaerPayment()
                        });

                        ret.catch(function (e) {
                            var messages = paypalexpress.findPaypal400Error(e);
                            console.log('paypal error', message, e);
                        });
                        return ret;
                    },

                    // onAuthorize() is called when the buyer approves the payment
                    onAuthorize: function (data, actions) {
                        return client.post(extraParams['capture_url'], {
                                payment: data,
                                shopping_cart: reactPayment.getShoppingCartData()
                            })
                            .then(resp => {
                                console.log('onAuthorize', resp)
                                reactPayment.onOrderPlaced(resp);
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
                        console.log('paypalexpress.cancelPay')
                    },
                    onError: function (data) {
                        var errorMessage = '';
                        var messages = paypalexpress.findPaypal400Error(data);
                        if (messages) {
                            errorMessage = 'Error:' + messages.name + '<br>';
                        }
                        errorMessage = errorMessage + 'Paypal Payment could not be executed. Please try again or choose other payment method.';
                        console.log('paypal error', errorMessage)
                    }
                },
                paypalSelector);
        },

        reInit: function () {
            return this.init(this.reactPayment, this.client, this.extraParams, this.paypalSelector)
        },

        prepaerPayment: function (cart) {
            console.log('tony prepaerPayment', cart)
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
            console.log('prepare payment', cart)
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
                    invoice_number: "c" + cart.customer_id + cart.guid + Math.floor(Date.now() / 1000),
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
