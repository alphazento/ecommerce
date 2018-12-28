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
        init: function (reactPaymentComponent, client, extraParams) {
            this.reactPaymentComponent = reactPaymentComponent;
            this.client = client;
            this.extraParams = extraParams
        },

        preCapture: function () {
            return this.client.post('/eway/accesscode');
        },

        capture: function () {
            this.preCapture().then(resp => {
                console.log('capture', resp);
            });
        },

        placeOrder: function () {
            if (this.reactPaymentComponent) {
                this.client.post(this.extraParams["prepare_endpoint"]).then(resp => {
                    if (resp.status === 200) {
                        let cardData = this.reactPaymentComponent.getCardData();
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
                            this.client.post(resp.data.action_url, eWayCardData).then(resp => {
                                console.log('eWayCardData', resp);
                            });
                        }
                    }
                });
            }
        }
    };
    return ewayTransparent;
}));