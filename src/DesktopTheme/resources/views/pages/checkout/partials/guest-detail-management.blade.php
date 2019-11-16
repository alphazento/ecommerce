@push('styles')
    #osc__sign-in-btn{
        background-color: orange;
        border-radius: 10px !important;
        width: 350px;
        max-width: 350px;
        font-size: 12px !important;
    }
    .typeahead.dropdown-menu{
        width: 575px !important;
    }
    .error{
        font-weight: 500 !important;
    }
@endpush
<div class="osc__block">
    <div class="osc__head">
        <h4 class="osc__h4">1. CUSTOMER INFORMATION</h4>
    </div>
    <div class="osc__body p-3">
        <div class="row">
            <div class="col-12 text-center">
                <button id="osc__sign-in-btn" type="button" class="loginBtn" data-toggle="modal" data-target="#sign-in-modal">Sign in with email</button>
            </div>
            <div class="col-12">
                @include('pages.checkout.partials.guest-email')
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @include('forms.base-full-address-form', ['formId' => 'delivery_address_form', 'data' => $quoteSnapshot->getDeliveryAddress() ?? Customer::now()->getDeliveryAddress()])
            </div>
        </div>
        <div class="row" >
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
        <div class="row checkout__billing_address" style="display: {{ $quoteSnapshot->isSameAddress() ? 'none' : 'block' }};">
            <div class="col-12">
                <h2 class="osc__h2">Invoice Address</h2>
            </div>
            <div class="col-12">
                @include('forms.base-full-address-form', ['formId' => 'billing_address_form', 'data' => $quoteSnapshot->getBillingAddress() ?? Customer::now()->getBillingAddress()])
            </div>
        </div>
        <div class="form-group">
            <label class="osc__customer-info-checkbox" for="subscribe-offers">
                Send me exclusive offers and coupons
                <input id="subscribe-offers"
                       class="form-check-input"
                       type="checkbox"
                       checked>
                <span class="checkmark"></span>
            </label>
        </div>
    </div>
</div>

@push('rqjs_body')
requirejs(['jQuery', 'windowLib'], function($, windowLib) {
    $('#same-billing-delivery-address').click(function() {
        if (this.checked){
            $('.checkout__billing_address').hide();
        } else {
            $('.checkout__billing_address').show();
        }
    });

    var guest_email = false;
    var guest_address_details = false;
    windowLib.onMessage('guest-email', function(data) {
        guest_email = data;
    }).onMessage('guest-addresses', function(data) {
        guest_address_details = data;
    })
    .onMessage('pre-place-order', function(data) {
        guest_email = false;
        guest_address_details = false;
        if (!windowLib.sendMessage('collect-guest-detail', {})) {
            console.log('error');
        }

        if (!guest_email) {
            return 'Please input valid email address';
        }
        if (guest_address_details && guest_address_details.hasOwnProperty('errors')) {
            return guest_address_details.errors;
        }

        var hasError = false;
        $.ajaxSync(true).ajaxPOST('/ajax/quote/guest-details',
            {email:guest_email, addresses: guest_address_details.addresses, useShippingAsBilling: guest_address_details.useShippingAsBilling},
            function(response) {
                if (!response['success']) {
                    hasError = response['message']['body'];
                    if (response['redirect']) {
                        window.location.href = response['redirect'];
                    }
                }
            },
            function(xhr) {
                if (xhr.status === 429) {
                    var retryAfter = (xhr.getResponseHeader('Retry-After'));
                    hasError = 'Too Many Attempts to change your details. Please retry after ' + retryAfter +'s';
                } else if (xhr.status = 422) {
                    var validationErrors = xhr.responseJSON.errors.validation;
                    var fields = Object.keys(validationErrors);
                    hasError = '';
                    fields.forEach(function(field) {
                        hasError += validationErrors[field] + "<br>";
                    });
                } else {
                    hasError = 'Http error happends. Please retry.';
                }
            });
        if (hasError) {
            return hasError;
        }
    });
})
@endpush
