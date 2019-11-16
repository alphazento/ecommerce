@push('styles')
    .cc-expiry {
        width: 100%;
        border: 1px solid #ced4da;
        display: flex;
        align-items: center;
        padding: 0;
    }
    .cc-expiry input{
        border: 0;
        width: 50%;
    }
    #eway-payment-information{
        padding: 0 15px;
    }
    #EWAY_CARDCVN::-webkit-input-placeholder {
        text-align:right;
        font-family: FontAwesome;
    }
    #EWAY_CARDCVN:-moz-placeholder {
        text-align:right;
        font-family: FontAwesome;
    }
    #EWAY_CARDCVN:-ms-input-placeholder {
        text-align:right;
        font-family: FontAwesome;
    }
@endpush

@php
    $thisYear = substr(Carbon\Carbon::now()->year, 2);
    $paymentCode = Inkstation\EwayTransparent\Services\PaymentMethod::PAYMENT_CODE;
    $paymentName = Inkstation\EwayTransparent\Services\PaymentMethod::PAYMENT_METHOD;
@endphp

<div id="eway-payment-information" style="display:none;">
    <form id="checkout__eway-prepay-form" action="{{ route('payment.prepay') }}" method="POST" name="checkout__eway-prepay-form">
        {{ Checkout::guid_field() }}
    </form>
    <form id="checkout__eway-form" action="{{ route('payment.prepay') }}" method="POST" name="checkout__eway-form">
        {{ Checkout::guid_field() }}
        <input type="hidden" name="payment_method" value="{{ $paymentName }}">
        <input type="hidden" name="EWAY_ACCESSCODE"/>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="EWAY_CARDNAME" class="osc__form-label">Name On Card <span>*</span></label>
                    <input name="EWAY_CARDNAME"
                           id="EWAY_CARDNAME"
                           data-rule-checkbrackets="true"
                           value=""
                           placeholder="Name on Card"
                           class="form-control"
                           maxlength="32"
                           type="text"
                           required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="EWAY_CARDNUMBER" class="osc__form-label">Card Number <span>*</span></label>
                    <input name="inputEwayCardNumber"
                           id="inputEwayCardNumber"
                           data-rule-digits-space-only="true"
                           class="form-control"
                           placeholder="Card Number"
                           maxlength="19"
                           no_trace="1"
                           type="text"
                           required>
                    <input name="EWAY_CARDNUMBER" id="EWAY_CARDNUMBER" type="hidden"/>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="osc__form-label">Expiry Date <span>*</span></label>
                    <input type="text"
                           id="inputExpDate"
                           name="inputExpDate"
                           class="form-control"
                           maxlength="7"
                           placeholder="MM / YY"
                           required>
                    <input type="hidden" name="EWAY_CARDEXPIRYMONTH" id="EWAY_CARDEXPIRYMONTH"/>
                    <input type="hidden" name="EWAY_CARDEXPIRYYEAR" id="EWAY_CARDEXPIRYYEAR"/>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="EWAY_CARDCVN" class="osc__form-label">Card CVN <span>*</span></label>
                    <input name="EWAY_CARDCVN"
                           no_trace="1"
                           id="EWAY_CARDCVN"
                           placeholder="&#xf283;"
                           maxlength="4"
                           class="form-control"
                           type="text"
                           required>
                </div>
            </div>
        </div>
    </form>
</div>


@push('rqjs_configs')
    require_add_config("ewaytransparent", @asset("/tonercitytheme/assets/js/payments/eway-transparent"), {deps:['jQuery'], exports:'ewaytransparent'});
@endpush

@push('rqjs_body')
    requirejs(['ewaytransparent', 'windowLib', 'loadingNotification', 'jquery.validate'],
        function(ewaytransparent, windowLib, modal) {

            var paymentCode = "{{ $paymentCode }}";

            $.validator.addMethod("checkbrackets", function(value, element) {
                    return value.indexOf('<') === -1 && value.indexOf('>') === -1;
                },
                "*Card holder name must not contain < or >."
            );

            $.validator.addMethod("digits-space-only", function(value, element){
                    return /^(?=.*\d)[\d ]+$/.test(value);
                },
                "*Only digits allowed"
            );

            $('#EWAY_CARDCVN').keypress(function(e) {
                if (e.which == 13) {
                    $('.placeorder').trigger('click');
                    return false;
                }
            });

            var updateCardName = function(customer) {
                if (customer) {
                    if (customer.customers_firstname && customer.customers_lastname) {
                        $('#EWAY_CARDNAME').val(customer.customers_firstname + " " + customer.customers_lastname);
                    } else {
                        var address = customer.delivery_address || customer.billing_address;
                        if (address && address.entry_firstname && address.entry_lastname) {
                            $('#EWAY_CARDNAME').val(address.entry_firstname + " " + address.entry_lastname);
                        }
                    }
                }
            };

            $.ewaytransparent.init($('#checkout__eway-prepay-form'), $('#checkout__eway-form'));

            windowLib.onMessage('pre-place-order', function (method) {
                if (method !== paymentCode) {
                    return;
                }

                if (!$.ewaytransparent.canCapture()) {
                    return "Payment details are not valid.";
                }
            })
            .onMessage('place-order', function (method) {
                if (method !== paymentCode) {
                    return;
                }
                $.ewaytransparent.capture(function (eway, data) {
                        if (data.success) {
                            setTimeout(function() {
                                modal.info('Processing...', 30000, function() {
                                    window.location.reload();
                                })
                            }, 30);
                            eway.transparentSubmit();
                        } else {
                            eway.redirect = data.redirect;
                            modal.error(data.message.body, 5000, function () {
                                if (eway.redirect !== undefined && eway.redirect) {
                                    window.location = eway.redirect;
                                }
                            });
                        }
                    }, function(eway, data) {
                        modal.error(data.message.body);
                    }
                );
            })
            .onMessage('payment_method-changed', function(data) {
                if (data["to"] !== paymentCode && data["to"] !== '*' ) {
                    return;
                }
                if (data['method'] === paymentCode) {
                    $('#eway-payment-information').show();
                } else {
                    $('#eway-payment-information').hide();
                }
            })
            .onMessage('customer-updated', function(customer) {
                updateCardName(customer);
            });

            updateCardName(@json(Customer::now()->toArray()));

            var initQuote = getGlobalConfigValue('init_quote');
            if (initQuote.payment_method === paymentCode) {
                $('#eway-payment-information').show();
            }

            var expiryDate = {
                monthAndSlashRegex: /^\d\d \/ $/,
                monthRegex: /^\d\d$/,
                el_expDate: '#inputExpDate',
            };

            $(expiryDate.el_expDate).on('keyup', function(e) {
                if(e.key === 'Backspace'){
                    expiryDate.removeSlash(e);
                }else{
                    expiryDate.addSlash(e);
                }
            });

            $(expiryDate.el_expDate).on('keypress', function(e) {
                return e.charCode >= 48 && e.charCode <= 57;
            });

            expiryDate.addSlash = function(e){
                var isMonthEntered = expiryDate.monthRegex.exec(e.target.value);
                if(e.target.value.length > 2){
                    $('#EWAY_CARDEXPIRYMONTH').val(e.target.value.slice(0, 2));
                }else{
                    $('#EWAY_CARDEXPIRYMONTH').val(e.target.value);
                }
                var pos = e.target.value.indexOf('/');
                if(e.target.value.length > 5){
                    if(pos !== -1){
                        $('#EWAY_CARDEXPIRYYEAR').val(e.target.value.slice(pos + 2, e.target.value.length));
                    }
                }
                if (e.key >= 0 && e.key <= 9 && isMonthEntered) {
                    e.target.value = e.target.value + " / ";
                }else if(!isMonthEntered && e.target.value.length >= 3 && pos === -1){
                    if(e.target.value.length > 4){
                        e.target.value = e.target.value.slice(0, 4);
                    }
                    expiryDate.reFormat(e);
                }
            };

            expiryDate.removeSlash = function(e) {
                var isMonthAndSlashEntered = expiryDate.monthAndSlashRegex.exec(e.target.value);
                if (isMonthAndSlashEntered && e.key === 'Backspace') {
                    e.target.value = e.target.value.slice(0, -3);
                }
            };

            expiryDate.reFormat = function(e) {
                if(e.target.value.length >= 3){
                    var mm = e.target.value.slice(0, 2);
                    var yy = e.target.value.slice(2, e.target.value.length);
                    e.target.value = mm + ' / ' + yy;
                    $('#EWAY_CARDEXPIRYMONTH').val(mm);
                    $('#EWAY_CARDEXPIRYYEAR').val(yy);
                }
            }

            function card_number_format(value) {
                var v = value.replace(/\s+/g, '').replace(/[^0-9]/gi, '')
                var matches = v.match(/\d{4,16}/g);
                var match = matches && matches[0] || ''
                var parts = []
                for (i=0, len=match.length; i < len; i+=4) {
                    parts.push(match.substring(i, i+4))
                }
                if (parts.length) {
                    return parts.join(' ')
                } else {
                    return value
                }
            }

            var cardNumber = {
                el_element: '#inputEwayCardNumber',
                card_number_element: '#EWAY_CARDNUMBER',
                digitsRegex: /^\d\d$/,
            };

            $(cardNumber.el_element).on('input', function(e){
                this.value = card_number_format(this.value);
                $(cardNumber.card_number_element).val($(this).val().replace(/\s+/g, ''));
            });


    });
@endpush
