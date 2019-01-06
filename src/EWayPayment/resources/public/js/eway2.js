(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define(factory);
    } else if (typeof exports === 'object') {
        module.exports = factory();
    } else {
        var oldEway = window.ewaypayment;
        var ewaypayment = window.ewaypayment = factory();
        ewaypayment.noConflict = function () {
            window.ewaypayment = oldEway;
            return ewaypayment;
        };
    }
}(function () {
    var ewayTransparent = {
        init: function (reactPayment, client, extraParams) {
            this.reactPayment = reactPayment;
            this.client = client;
            this.extraParams = extraParams
        },

        preCapture: function (shoppingCart) {
            this.reactPayment.openRedirectWindow("ewaypayment");
            return this.client.post(this.extraParams["prepare_endpoint"], shoppingCart);
        },

        // capture: function () {
        //     this.preCapture().then(resp => {
        //         console.log('capture', resp);
        //     });
        // },

        capturePayment: function (shoppingCart, cardData) {
            this.preCapture(shoppingCart).then(resp => {
                if (resp.status === 200) {
                    if (cardData) {
                        let expiry = cardData["expiry"].split("/");
                        let eWayCardData = {
                            EWAY_ACCESSCODE: resp.data.access_code,
                            EWAY_CARDNUMBER: cardData['number'].replace(/ /g, ''),
                            EWAY_CARDNAME: cardData['name'],
                            EWAY_CARDEXPIRYMONTH: expiry[0],
                            EWAY_CARDEXPIRYYEAR: expiry[1],
                            EWAY_CARDCVN: cardData['cvc'],
                        };
                        console.log('eWayCardData', eWayCardData);
                        this.reactPayment.postUrlInRedirectWindow(resp.data.action_url, eWayCardData);
                    }
                }
            });
        },

        postPayment: function (transferQuery, transferPostData, shoppingCart) {
            if (this.reactPayment) {
                this.client.post('/payment/postsubmit/ewaypayment' + transferQuery, {
                    from_gateway: transferPostData,
                    shopping_cart: shoppingCart,
                }).then(resp => {
                    if (resp.status === 201) {
                        this.reactPayment.onPaymentCaptured(result);
                    } else {

                    }
                })
            }
        }
    };
    return ewayTransparent;
}));
