define(['jQuery', 'jquery.validate'], function ($) {
    var ewayFormValidate = {
        rules: {
            inputExpDate:{
                minlength: 7
            },
            EWAY_CARDCVN: {
                digits: true,
                maxlength: 4
            }
        },
        messages: {
            EWAY_CARDNAME: {
                required: '*Please enter the full name on the card'
            },
            EWAY_CARDNUMBER: {
                required: '*Please enter the card number',
            },
            inputExpDate:{
                required: '*Please enter the expiry date',
                minlength: '*Please enter the valid expiry date'
            },
            EWAY_CARDCVN: {
                required: '*Please enter the CVN',
                digits: '*Only digits allowed',
                maxlength: '*Maximum 4 digits allowed'
            }
        },
    };
    $.ewaytransparent = {
        init: function (prepayForm, eWayForm) {
            this.prepayForm = prepayForm;
            this.eWayForm = eWayForm;
            this.eWayForm.validate(ewayFormValidate);
        },

        canCapture: function () {
            return this.eWayForm.valid();
        },

        setFormActionUrl: function (value) {
            this.eWayForm.attr('action', value);
            return this;
        },

        setAccessCode: function (value) {
            this.eWayForm.find('input[name="EWAY_ACCESSCODE"]').val(value);
            return this;
        },

        capture: function (onSuccess, onError) { //prepay
            var pthis = this;
            return $.ajaxPOST(pthis.prepayForm.attr('action'), pthis.prepayForm.serialize(),
                function (data) {
                    var dataLoad = data['data'];
                    if (data.success) {
                        pthis.setFormActionUrl(dataLoad['form_action_url'])
                            .setAccessCode(dataLoad['access_code']);
                        if (onSuccess !== undefined) {
                            onSuccess(pthis, data);
                        }
                    } else {
                        if (onError !== undefined) {
                            onError(pthis, data);
                        }
                    }
                },
                onError,
                'Your payment is in processing. <br>Please do not leave or refresh this page during this process.'
            );
        },

        transparentSubmit: function () {
            this.eWayForm.submit();
            return;
        }
    };
    return $.ewaytransparent;
});
