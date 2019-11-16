<div class="osc__block">
    <div class="osc__head">
        <h4 class="osc__h4">1. CUSTOMER INFORMATION</h4>
    </div>
    <div class="osc__body p-3">
        <div class="row">
            <div class="col-12">
                <span class="osc__address-valid-fail" style="display:none;"><strong>Please select delivery address!</strong></span>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @includeWhen(!Auth::isFullLogin(), 'pages.checkout.partials.guest-email')
            </div>
        </div>
        @include('pages.checkout.partials.authed-address-list.address-list', ['type' => 'delivery'])
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label class="osc__customer-info-checkbox" for="same-billing-delivery-address">
                        Invoice address same as delivery address
                        <input id="same-billing-delivery-address"
                               class="form-check-input"
                               type="checkbox"
                                {{ $quoteSnapshot->isSameAddress() ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                    </label>
                </div>
            </div>
        </div>
        @include('pages.checkout.partials.authed-address-list.address-list', ['type' => 'invoice'])
    </div>
</div>

@push('rqjs_body')
requirejs(['jQuery', 'windowLib'], function($, windowLib) {
    var addresses = @json($addresses);
    addresses = addresses || [];

    var deliveryAddressId = "{{$quoteSnapshot->getDeliveryAddressId()}}";
    var billingAddressId = "{{$quoteSnapshot->getBillingAddressId()}}";

    var $invoiceAddressContainer = $('#osc__invoice-address-container');
    var $sameAddressCheckbox = $('#same-billing-delivery-address');

    $('#delivery-address-part').show();
    if (!$sameAddressCheckbox.is(':checked')) {
        $('#invoice-address-part').show();
    }

    renderAddresses(getGlobalConfigValue('init_quote'));

    $('.delivery-address-selector').click(function() {
        var addressId = this.value;
        var addressType = $sameAddressCheckbox.is(':checked') ? 'both' : 'delivery';
        $.ajaxPUT("/ajax/quote/addresses/" + addressId + "/" + addressType, {},
            function(data) {
                if (data['success']) {
                    $(".osc__address-valid-fail").hide();
                }
                windowLib.sendMessage('osc-ajax-responsed', data);
            }
        );
    });

    $('.invoice-address-selector').click(function() {
        var addressId = this.value;
        $.ajaxPUT("/ajax/quote/addresses/" + addressId + "/billing", {},
            function(data) {
                windowLib.sendMessage('osc-ajax-responsed', data);
            }
        );
    });

    $sameAddressCheckbox.on('change', function() {
        if (this.checked) {
            if (deliveryAddressId !== billingAddressId) {
                $.ajaxPUT("/ajax/quote/addresses/" + deliveryAddressId + "/billing", {},
                    function(data) {
                        windowLib.sendMessage('osc-ajax-responsed', data);
                    }
                );
            }
            $invoiceAddressContainer.hide();
        } else {
            $invoiceAddressContainer.show();
        }
    });

    windowLib
        .onMessage('address-added', function(data) {
            addresses = data.addresses;
            renderAddresses(data.quoteSnapshot);
        })
        .onMessage('pre-place-order', function(method) {
            if (!deliveryAddressId) {
                $(".osc__address-valid-fail").show();
                return 'Please set delivery address first';
            }
        })
        .onMessage('quote-updated', function(quote) {
            renderAddresses(quote);
        });

    function renderAddresses(quote) {
        deliveryAddressId = quote.delivery_address_id;
        billingAddressId = quote.billing_address_id;
        var isSame = (billingAddressId == deliveryAddressId)
            || billingAddressId == null || deliveryAddressId == null
            || billingAddressId == '' || deliveryAddressId == ''
            || billingAddressId === undefined || deliveryAddressId === undefined;

        $sameAddressCheckbox.prop('checked', isSame);
        renderAddressRadios('delivery', isSame);
        renderAddressRadios('invoice', isSame);
    }

    function bindAddressData(type, i, address) {
        var radio = $("#" + type + "-address-radio-" + i);
        radio.val(address.address_book_id);
        var blockSelector = '#' + type + "-address-block-" + i;
        $(blockSelector).show();
        $(blockSelector + " .address-fullname").text(address.entry_firstname + " " + address.entry_lastname);
        $(blockSelector + " .phone-number").text(address.entry_telephone);
        $(blockSelector + " .address-company-name").text(address.entry_company);
        $(blockSelector + " .address-street1").text(address.entry_street_address);
        $(blockSelector + " .address-street2").text(address.entry_suburb);
        var extra = address.entry_city + ", " + address.entry_state + " " + address.entry_postcode;
        $(blockSelector + " .address-extra").text(extra);
        if (type === 'delivery' && deliveryAddressId == address.address_book_id) {
            radio.prop("checked", true);
        } else if (type === 'invoice' && billingAddressId == address.address_book_id) {
            radio.prop("checked", true);
        }
    };

    function renderAddressRadios(type, isSame) {

        var $container = $('#osc__' + type + '-address-container').hide();

        for (var i = 0; i < addresses.length; i++) {
            bindAddressData(type, i, addresses[i]);
        }
        for (var i = addresses.length; i < 20; i++) {
            var blockSelector = '#' + type + '-address-block-' + i;
            $(blockSelector).hide();
        }
        if (type === 'delivery' || !isSame) {
            $container.show();
        }
    }
})
@endpush

@push('footer')
    @include('components.modal-component', [
        'title' => 'New Address',
        'refId' => 'addressModal',
        'contentTemplate' => 'forms.checkout.new-address',
        'fade' => true,
        'large' => true,
    ])
@endpush
