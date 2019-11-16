@push('styles')
    .switch_back_to_address_lookup{
        color: #fff;
        background-color: #f4a100;
        font-weight: 400;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        user-select: none;
        border: 1px solid #f4a100;
        padding: .375rem .75rem;
        font-size: 13px;
        line-height: 1.5;
        border-radius: .25rem;
        margin-bottom: 5px;
    }

    .remove-full-address, .waiting-verify{
        align-items: center;
        bottom: 8px;
        color: rgba(0, 0, 0, .54);
        cursor: pointer;
        display: flex;
        height: 22px;
        justify-content: center;
        position: absolute;
        right: 0;
        width: 22px;
        z-index: 10;
        display: none;
    }
@endpush

@php
    $formId = $formId ?? 'address__form';
@endphp
<form role="form" class="address__form" id="{{$formId}}">
    <div>
        <div class="row">
            <input name="address_manager_type"
                   id="{{$formId}}-address_manager_type"
                   class="form-control"
                   type="hidden">

            <input name="address_book_id"
                   id="{{$formId}}-address_book_id"
                   class="form-control"
                   type="hidden">

            <div class="col-sm-6">
                <div class="form-group">
                    <label class="osc__form-label">First Name <span>*</span></label>
                    <input name="entry_firstname"
                           id="{{$formId}}-entry_firstname"
                           class="form-control"
                           placeholder="First Name" required
                           value="{{$data['entry_firstname'] ?? ''}}"
                           type="text" autocomplete="tonercity">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="osc__form-label">Last Name <span>*</span></label>
                    <input name="entry_lastname"
                           id="{{$formId}}-entry_lastname"
                           class="form-control"
                           placeholder="Last Name" required
                           value="{{$data['entry_lastname'] ?? ''}}"
                           type="text" autocomplete="tonercity">
                </div>
            </div>
            @if($formId !== 'billing_address_form')
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="osc__form-label">Telephone<span>*</span></label>
                    <input name="entry_telephone"
                           id="{{$formId}}-entry_telephone"
                           class="form-control"
                           maxlength="11"
                           placeholder="Telephone Number"
                           value="{{$data['entry_telephone'] ?? ''}}"
                           type="text" autocomplete="tonercity">
                </div>
            </div>
            @endif
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="osc__form-label">Company Name (Optional)</label>
                    <input name="entry_company"
                           id="{{$formId}}-entry_company"
                           value="{{$data['entry_company'] ?? ''}}"
                           class="form-control"
                           placeholder="Business Name (Optional)"
                           type="text" autocomplete="tonercity">
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group" style="min-height: 100px;">
                    <div style="display: block;">
                        <div id="full_address_box" class="form-group mc-reg-grp" style="position: relative;">
                            @if($formId !== 'billing_address_form')
                            <label class="osc__form-label">Address<span>*</span></label>
                            @else
                            <label class="osc__form-label">Invoice Address<span>*</span></label>
                            @endif
                            <div class="init-address-lookup" id="{{$formId}}-init-address-lookup" formid="{{$formId}}"><i class="fa fa-spinner fa-pulse fa-lg"></i></div>
                            <input name="full_address"
                                   id="{{$formId}}-full_address"
                                   formid="{{$formId}}"
                                   class="form-control mc-reg-txtbox autocomplete-address__connector clearInputs"
                                   autocomplete="tonercity"
                                   placeholder="Start typing your address"
                                   style="padding-right: 30px; display: none"
                                   value="{{$data['full_address'] ?? ''}}"
                            >
                            <span id="{{$formId}}-full_address-error" class="error" style="display: none;">
                                <span style="color: red;">*</span>Please enter valid address
                            </span>
                            <span class="remove-full-address" id="{{$formId}}-remove-full-address" formid="{{$formId}}"><i class="fa fa-times"></i></span>
                            <span class="waiting-verify" id="{{$formId}}-waiting-verify" formid="{{$formId}}"><i class="fa fa-spinner fa-pulse"></i></span>
                            <div class="clearfix"></div>
                        </div>
                        <div id="details_address" style="display: none;">
                            <div class="form-group mc-reg-grp">
                                @if($formId !== 'billing_address_form')
                                <label class="osc__form-label">Address Line 1<span>*</span></label>
                                @else
                                <label class="osc__form-label">Invoice Address Line 1<span>*</span></label>
                                @endif
                                <button type="button"
                                        class="switch_back_to_address_lookup pull-right"
                                        formid="{{$formId}}">Switch to address lookup</button>
                                <input name="entry_street_address"
                                       id="{{$formId}}-entry_street_address"
                                       formid="{{$formId}}"
                                       required
                                       value="{{$data['entry_street_address'] ?? ''}}"
                                       placeholder="Enter address line 1"
                                       class="form-control mc-reg-txtbox clearInputs"
                                       autocomplete="tonercity">
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group mc-reg-grp">
                                @if($formId !== 'billing_address_form')
                                    <label class="osc__form-label">Address Line 2</label>
                                @else
                                    <label class="osc__form-label">Invoice Address Line 2</label>
                                @endif
                                <input name="entry_suburb"
                                       id="{{$formId}}-entry_suburb"
                                       formid="{{$formId}}"
                                       value="{{$data['entry_suburb'] ?? ''}}"
                                       placeholder="Enter address line 2"
                                       class="form-control mc-reg-txtbox clearInputs"
                                       autocomplete="tonercity">
                                <div class="clearfix"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mc-reg-grp">
                                        <label class="osc__form-label">Suburb<span>*</span></label>
                                        <input name="entry_city"
                                               id="{{$formId}}-entry_city" required
                                               formid="{{$formId}}"
                                               type="text"
                                               class="form-control mc-reg-txtbox entry_city clearInputs"
                                               value="{{$data['entry_city'] ?? ''}}"
                                               placeholder="Suburb"
                                               autocomplete="tonercity">
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mc-reg-grp">
                                        <label class="osc__form-label">Postcode<span>*</span></label>
                                        <input name="entry_postcode"
                                               id="{{$formId}}-entry_postcode" required
                                               formid="{{$formId}}"
                                               type="text"
                                               class="form-control mc-reg-txtbox entry_postcode clearInputs"
                                               maxlength="4" minlength="4"
                                               value="{{$data['entry_postcode'] ?? ''}}"
                                               placeholder="Postcode"
                                               autocomplete="tonercity">
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mc-reg-grp">
                                        <label class="osc__form-label">State<span>*</span></label>
                                        <select name="entry_state"
                                                id="{{$formId}}-entry_state" required
                                                class="form-control mc-reg-txtbox"
                                                style="height: 40px;"
                                        >
                                            <option value="default">Choose a state</option>
                                            <option value="ACT" {{isset($data['entry_state']) && $data['entry_state'] === 'ACT' ? 'selected' : ''}}>ACT</option>
                                            <option value="NT" {{isset($data['entry_state']) && $data['entry_state'] === 'NT' ? 'selected' : ''}}>NT</option>
                                            <option value="SA" {{isset($data['entry_state']) && $data['entry_state'] === 'SA' ? 'selected' : ''}}>SA</option>
                                            <option value="WA" {{isset($data['entry_state']) && $data['entry_state'] === 'WA' ? 'selected' : ''}}>WA</option>
                                            <option value="NSW" {{isset($data['entry_state']) && $data['entry_state'] === 'NSW' ? 'selected' : ''}}>NSW</option>
                                            <option value="QLD" {{isset($data['entry_state']) && $data['entry_state'] === 'QLD' ? 'selected' : ''}}>QLD</option>
                                            <option value="VIC" {{isset($data['entry_state']) && $data['entry_state'] === 'VIC' ? 'selected' : ''}}>VIC</option>
                                            <option value="TAS" {{isset($data['entry_state']) && $data['entry_state'] === 'TAS' ? 'selected' : ''}}>TAS</option>
                                        </select>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mc-rep-grp">
                                        <label class="osc__form-label">Country<span>*</span></label>
                                        <input name="entry_country"
                                               id="{{$formId}}-entry_country"
                                               class="form-control mc-reg-txtbox"
                                               value="Australia"
                                               readonly
                                               required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@include('components.autocomplete-address')

@pushonce('address__form', 'rqjs_body')
requirejs(['jQuery', 'windowLib', 'addressFinder', 'jquery.validate', 'typeahead', 'lodash'], function($, windowLib, addressFinder) {

    var urlForGettingAddressesBySuburb = '/load-suburbs?type=locality';
    var urlForGettingAddressesByPostcode = '/load-suburbs?type=pcode';

    var debouncedGetAddresses = _.debounce(function(url, query, process) {
        return $.get(url, { term: query }, function(data) { process(data); });
    }, 500);

    if ($('input[name="full_address"]').length > 0) {
        $('input[name="full_address"]').each(function() {
            var formId = $(this).attr('formid');
            $('#' + formId).find('.clearInputs').val('');
            $('#' + formId).find('input[name="full_address"]').attr('readonly', false);
            $('.remove-full-address', '#' + formId).hide();
            $('#' + formId + '-init-address-lookup').hide();
            $(this).show();
        });
    }

    $.validator.setDefaults({
        ignore: [],
    });

    $.validator.addMethod("valueNotEquals", function(value, element, arg) {
        return arg != value;
    }, "Value must not equal arg.");

    $.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z]+$/i.test(value);
    }, "Only alphabetic characters are allowed.");

    var addressFormValidation = {
        rules: {
            entry_firstname: {
                maxlength: 30,
                lettersonly: true,
                required: true
            },
            entry_lastname: {
                maxlength: 30,
                lettersonly: true,
                required: true
            },
            entry_company: {
                maxlength: 32
            },
            entry_telephone: {
                digits: true,
                maxlength: 11,
                required: true
            },
            entry_postcode: {
                required: true,
                digits: true,
                minlength: 4,
                maxlength: 4
            },
            entry_state: {
                valueNotEquals: 'default'
            }
        },
        messages: {
            entry_firstname: {
                lettersonly: '*Only alphabetic characters are allowed.',
                required: '*Please enter your first name.'
            },
            entry_lastname: {
                lettersonly: '*Only alphabetic characters are allowed.',
                required: '*Please enter your last name.'
            },
            entry_telephone: {
                required: '*Please enter your contact number.',
                maxlength: '*Maximum 11 digits only',
                digits: '*Only numbers are allowed.'
            },
            entry_street_address: {
                required: '*Please enter your address',
            },
            entry_postcode: {
                required: '*Please enter post code',
                digits: '*Only numbers are allowed.',
                minlength: '*Please enter 4 digits for postcode.',
                maxlength: '*Please enter 4 digits for postcode.'
            },
            entry_city: {
                required: '*Please choose/enter your suburb.'
            },
            entry_state: {
                valueNotEquals: '*Please select a state'
            }
        },
        invalidHandler: function(event, validator) {
            var formId = event.currentTarget.id;
            $.each(validator.errorList, function(key, val) {
                if (['entry_street_address', 'entry_postcode', 'entry_city', 'entry_state'].indexOf(val.element.name) !== -1) {
                    $('#' + formId + '-full_address-error').show();
                    return false;
                }
            });
        }
    };

    $('.address__form').each(function() {
        $(this).validate(addressFormValidation);
    });

    windowLib.onMessage('collect-guest-detail', function(data) {
        var $deliveryAddressForm = $("#delivery_address_form");
        var $billingAddressForm = $("#billing_address_form");

        if ($deliveryAddressForm.length > 0 && $billingAddressForm.length > 0) {
            var $sameAddressCheckbox = $('#same-billing-delivery-address');
            var useSameAddress = $sameAddressCheckbox.length && $sameAddressCheckbox[0].checked;

            var deliveryAddressFormValidator = $deliveryAddressForm.validate(addressFormValidation);
            var billingAddressFormValidator = $billingAddressForm.validate(addressFormValidation);

            if (!deliveryAddressFormValidator.form() || !useSameAddress && !billingAddressFormValidator.form()) {
                var errors = formatValidationErrors(deliveryAddressFormValidator.errorMap, 'delivery address');
                errors += formatValidationErrors(billingAddressFormValidator.errorMap, 'invoice address');
                windowLib.sendMessage('guest-addresses', { errors: errors })
                return;
            }

            var address_details = {
                addresses: {
                    shipping: {},
                },
                useShippingAsBilling: useSameAddress
            }

            jQuery.each($deliveryAddressForm.serializeArray(), function(i, field) {
                address_details.addresses.shipping[field.name] = field.value;
            });

            if (!useSameAddress) {
                address_details.addresses['billing'] = {};
                jQuery.each($billingAddressForm.serializeArray(), function(i, field) {
                    address_details.addresses.billing[field.name] = field.value;
                });
            }

            windowLib.sendMessage('guest-addresses', address_details);
        }
    });

    windowLib.onMessage('init-address-form', function(data) {

        var formId = false;
        if (data !== undefined && data.hasOwnProperty('formToBeCleared')) {
            var formId = data['formToBeCleared'];
        }

        if (data !== undefined && Object.keys(data).length !== 0 && !formId) {
            var form = $('#' + data['formid']);
            var address = data['address'];
            if (address !== undefined) {
                var keys = Object.keys(address);
                for (var i = 0; i < keys.length; i++) {
                    var box = $("[name='" + keys[i] + "']", form[0]);
                    if (box.length) {
                        box.val(address[keys[i]]);
                        if (keys[i] === 'full_address') {
                            box.attr('readonly', true);
                            $('.remove-full-address', form[0]).show();
                        }
                    }
                }
            }
        } else {
            // Get one specific form, delivery or billing, not both.
            var $form = $('#' + formId);
            // Only need to clear full address of a specific form if "Address Not Found?..." entry is selected,
            // not all input of that form.
            $form.find("[name='full_address']").val('');
            $form.find("[name='full_address']").attr('readonly', false);
            $form.find('.remove-full-address').hide();
        }
    });

    addressFinder.connect(".autocomplete-address__connector", function(data, formid) {
        var address = {};
        address['full_address'] = data['full_address'];
        address['entry_street_address'] = data['address_line_1'];
        if (data['address_line_2']) {
            address['entry_suburb'] = data['address_line_2'];
        }
        address['entry_postcode'] = data['postcode'];
        address['entry_state'] = data['state_territory'];
        address['entry_city'] = data['locality_name'];
        windowLib.sendMessage('init-address-form', { address: address, formid: formid });
    }, function(formid) {
        var form = $('#' + formid);
        $("#full_address_box", form[0]).hide();
        $("#details_address", form[0]).show();
        windowLib.sendMessage('init-address-form', { formToBeCleared: formid });
    });

    $('.remove-full-address').click(function() {
        $(this).hide();
        var formId = $(this).attr('formId');
        $('#' + formId + '-full_address').attr('readonly', false);
        $('#' + formId + '-full_address').attr('disabled', false);
        $('#' + formId).find('.clearInputs').val('');
    });

    $('.switch_back_to_address_lookup').click(function(e) {
        e.preventDefault();
        var formid = $(this).attr('formid');
        var form = $('#' + formid);
        $("#details_address", form[0]).hide();
        $('#full_address_box', form[0]).show();
        addressFinder.modes[formid] = '';
    });

    $('.entry_postcode').typeahead({
        displayText: function(item) {
            return item.label;
        },
        source: function(query, process) {
            debouncedGetAddresses(urlForGettingAddressesByPostcode, query, process);
        },
        updater: function(item) {
            var formId = this.$element.attr('formid');
            if (!formId) {
                formId = '';
            }
            $('#' + formId + '-entry_city').val(item.city);
            $('#' + formId + '-entry_state').val(item.state);
            return item.postcode;
        },
        autoSelect: true
    });

    $('.entry_city').typeahead({
        displayText: function(item) {
            return item.label;
        },
        source: function(query, process) {
            debouncedGetAddresses(urlForGettingAddressesBySuburb, query, process);
        },
        updater: function(item) {
            var formId = this.$element.attr('formid');
            if (!formId) {
                formId = '';
            }
            $('#' + formId + '-entry_postcode').val(item.postcode);
            $('#' + formId + '-entry_state').val(item.state);
            return item.city;
        },
        autoSelect: true
    });

    function formatValidationErrors(errorMap, address) {
        var allErrors = '';
        var fields = Object.keys(errorMap);
        fields.forEach(function(field) {
            var error = errorMap[field].replace(/\*/, '');
            error = error.replace(/\./, '');
            allErrors += error + ' in ' + field.replace('entry_', '') + ' of ' + address + '<br>';
        })
        return allErrors;
    }
});
@endpushonce
