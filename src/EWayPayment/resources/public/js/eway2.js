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
        init: function (reactScope, client, extraParams) {
            this.reactScope = reactScope;
            this.client = client;
            this.extraParams = extraParams
        },

        placeOrder: function (params) {
            if (this.reactScope) {
                this.reactScope.popupWindow("ewaypayment");
                this.client.post(this.extraParams["prepare_endpoint"], params).then(resp => {
                    if (resp.status === 200) {
                        let cardData = this.reactScope.getCardData();
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
                            this.reactScope.postToNewWindow(resp.data.action_url, eWayCardData);

                            // this.client.post(resp.data.action_url, eWayCardData).then(resp => {
                            //     console.log('eWayCardData', resp);
                            // });
                        }
                    }
                });
            }
        },

        postPayment: function (result) {
            if (this.reactScope) {
                this.client.post('/payment/postsubmit/ewaypayment' + result.query).then(resp => {
                    if (resp.status === 200) {
                        this.reactScope.orderPlaced(result);
                    } else {

                    }
                })
            }
        }
    };
    return ewayTransparent;
}));
