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
        font-size: 1rem;
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
        display:none;
    }
@endpush
<?php $formId = $formId ?? 'register_address__form' ?>
<section>
    <form role="form" class="register_address__form" id="{{$formId}}" method="post" action="{{ route('register') }}">
        @csrf_field()
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3>Your Details</h3>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>First Name <span class="required">*</span></label>
                                    <input name="firstname" id="{{$formId}}-entry_firstname" class="form-control" required
                                           value="{{ old('firstname') }}" type="text" placeholder="First Name">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Last Name <span class="required">*</span></label>
                                    <input name="lastname" id="{{$formId}}-entry_lastname" class="form-control" required
                                           value="{{ old('lastname') }}" type="text" placeholder="Last Name">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Email Address<span class="required">*</span></label>
                                    <input name="email" id="register_email" class="form-control" required
                                           value="{{ old('email') }}"
                                           type="email" placeholder="Email Address">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Phone Number<span class="required">*</span></label>
                                    <input name="telephone" id="{{$formId}}-entry_telephone" class="form-control" required
                                           maxlength="12"
                                           value="{{ old('telephone') }}" type="text" placeholder="Contact Number">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Password <span class="required">*</span></label>
                                    <input name="password" id="password" class="form-control" type="password" required
                                           maxlength="40" minlength="8" placeholder="Password">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Confirm Password <span class="required">*</span></label>
                                    <input name="password_confirmation" class="form-control" id="password_confirmation"
                                           type="password" required maxlength="40" placeholder="Password Confirmation">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3>Your Address</h3>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div id="full_address_box" style="display: block;">
                                        <div class="form-group mc-reg-grp" style="position: relative;">
                                            <label>Address Lookup <span class="required">*</span></label>
                                            <div class="init-address-lookup" id="{{$formId}}-init-address-lookup" formid="{{$formId}}"><i class="fa fa-spinner fa-pulse fa-lg"></i></div>
                                            <input name="full_address"
                                                id="{{$formId}}-full_address"
                                                formid="{{$formId}}"
                                                class="form-control mc-reg-txtbox autocomplete-address__connector clearInputs"
                                                placeholder="Start typing your address"
                                                autocomplete="disable"
                                                value="{{ old('full_address')}}" style="display: none;">
                                            <span id="{{$formId}}-full_address-error" class="error" for="full_address" style="display: none">Please enter valid address</span>
                                            <span class="waiting-verify" id="{{$formId}}-waiting-verify" formid="{{$formId}}"><i class="fa fa-spinner fa-pulse"></i></span>
                                            <span class="remove-full-address" id="{{$formId}}-remove-full-address" formid="{{$formId}}"><i class="fa fa-times"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="details_address" class="col-sm-12" style="display:none;">
                            <div class="col-sm-12">
                                <button class="switch_back_to_address_lookup" formid="{{$formId}}">  Switch back to address lookup </button>
                                <div class="form-group">
                                    <label>Street Address 1<span class="required">*</span></label>
                                    <input name="street_address"
                                           class="form-control clearInputs"
                                           id="{{$formId}}-entry_street_address"
                                           formid="{{$formId}}"
                                           required
                                           value="{{ old('street_address') }}"
                                           type="text" placeholder="">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Street Address 2</label>
                                    <input name="street_address_2"
                                           class="form-control clearInputs"
                                           id="{{$formId}}-entry_suburb"
                                           formid="{{$formId}}"
                                           value="{{ old('street_address_2') }}"
                                           placeholder=""
                                           type="text">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Postcode<span class="required">*</span></label>
                                    <input name="postcode"
                                           id="{{$formId}}-entry_postcode"
                                           formid="{{$formId}}"
                                           class="entry_postcode form-control clearInputs"
                                           required
                                           value="{{ old('postcode') }}" maxlength="4" minlength="4"
                                           type="search" placeholder="Postcode"
                                           autocomplete="disable">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Suburb<span class="required">*</span></label>
                                    <input name="city"
                                           id="{{$formId}}-entry_city"
                                           formid="{{$formId}}"
                                           class="entry_city form-control clearInputs"
                                           required value="{{ old('city') }}"
                                           type="search" placeholder="Suburb"
                                           autocomplete="disable">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>State<span class="required">*</span></label>
                                    <select name="state"
                                            id="{{$formId}}-entry_state"
                                            required
                                            class="form-control">
                                        <option value="">Choose a state</option>
                                        @foreach($states as $state)
                                            <option value="{{ $state }}" {{ old('state') == $state ? 'selected' : '' }}>{{ $state }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Company Name</label>
                                    <input name="company" id="company" class="form-control" value="{{ old('company') }}"
                                           placeholder="Leave blank if not applicable" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label><input name="newsletter" id="newsletter" value="1" type="checkbox"
                                      checked> Email me the latest exclusive offers and deals from TonerCity
                        </label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group position-create-account-btn">
                        <button id="create-account-button"
                                data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Creating Your Account"
                                type="submit"
                                class="btn btn-success request-loading disable-before-address-verify">Create an Account
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>

@include('components.autocomplete-address')
@pushonce('register_address__form', 'rqjs_body')
requirejs(['jQuery', 'windowLib', 'addressFinder', 'jquery.validate', 'typeahead'], function ($, windowLib, addressFinder, jqvalid) {

    var $addressFinder = $('input[name="full_address"]');
    var formId = $addressFinder.attr('formid');
    windowLib.sendMessage('init-address-form', {});
    $('#' + formId + '-init-address-lookup').hide();
    $addressFinder.show();

    var urlForGettingAddressesBySuburb = '/load-suburbs?type=locality';
    var urlForGettingAddressesByPostcode = '/load-suburbs?type=pcode';

    var debouncedGetAddresses = _.debounce(function(url, query, process) {
        return $.get(url, { term: query }, function(data) { process(data); });
    }, 500);

    $.validator.setDefaults({
        ignore: [],
    });
    $.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z]+$/i.test(value);
    }, "Only alphabetic characters are allowed.");
    var registerValidation = {
        rules: {
            email: {
                email: true
            },
            firstname: {
                maxlength: 30,
                lettersonly: true,
                required: true
            },
            lastname: {
                maxlength: 30,
                lettersonly: true,
                required: true
            },
            company: {
                maxlength: 32
            },
            street_address: {
                maxlength: 64
            },
            street_address_2: {
                maxlength: 32
            },
            city: {
                maxlength: 32,
                required: true
            },
            password_confirmation: {
                equalTo: "#password"
            },
            postcode: {
                digits: true
            },
            telephone: {
                digits: true,
                maxlength: 12,
                required: true
            }
        },
        messages: {
            firstname: {
                required: 'Please enter your first name.'
            },
            lastname: {
                required: 'Please enter your last name.'
            },
            email: {
                required: 'Please enter your email address.'
            },
            password: {
                required: 'Please enter your password.'
            },
            password_confirmation: {
                required: 'Please enter the same password again.',
                equalTo: 'Please enter the same password again.'
            },
            telephone: {
                digits: 'Only numbers are allowed.',
                required: 'Please enter your contact number.',
                maxlength: 'Maximum 12 digits only'
            },
            postcode: {
                required: 'Please choose/enter your postcode',
                minlength: 'Please enter 4 digits for postcode'
            },
            city: {
                required: 'Please choose/enter your suburb.'
            },
            state: 'Please select a state'
        },
        submitHandler: function (form) {
            $('#create-account-button').button('loading');
            form.submit();
        },
        invalidHandler: function (event, validator){
            var formId = event.currentTarget.id;
            $.each(validator.errorList, function(key, val){
                if(['street_address', 'postcode', 'city', 'state'].indexOf(val.element.name) !== -1){
                    $('#' + formId + '-full_address-error').show();
                    return false;
                }
            });
        }
    };

    $('.register_address__form').validate(registerValidation);

    windowLib.onMessage('init-address-form', function(data) {
        if (data !== undefined && Object.keys(data).length !== 0) {
            var form = $('#' + data['formid']);
            var address = data['address'];
            if (address !== undefined) {
                var keys = Object.keys(address);
                for(var i=0; i < keys.length; i++) {
                    var box = $("#"+data['formid']+"-"+keys[i], form[0]);
                    if (box.length) {
                        box.val(address[keys[i]]);
                    }
                }
            }
        } else {
            $('.register_address__form').find('.clearInputs').val('');
        }
    });

    addressFinder.connect(".autocomplete-address__connector", function(data, formid) {
        var address = {};
        address['full_address'] = data['full_address'];
        address['entry_street_address'] = data['address_line_1'];
        address['entry_suburb'] = data['address_line_2'];
        address['entry_postcode'] = data['postcode'];
        address['entry_state'] = data['state_territory'];
        address['entry_city'] = data['locality_name'];
        windowLib.sendMessage('init-address-form', {address:address, formid:formid});
    }, function(formid) {
        var form = $('#' + formid);
        $("#full_address_box", form[0]).hide();
        $("#details_address", form[0]).show();
        windowLib.sendMessage('init-address-form', {});
    });

    $('.remove-full-address').click(function(){
        $(this).hide();
        var formId = $(this).attr('formId');
        $('#'+ formId + '-full_address').attr('readonly', false);
        $('#'+ formId + '-full_address').attr('disabled', false);
        $('#' + formId).find('.clearInputs').val('');
    });

    $('.switch_back_to_address_lookup').click(function (e) {
        e.preventDefault();
        var formid = $(this).attr('formid');
        var form = $('#' + formid);
        $("#details_address", form[0]).hide();
        $('#full_address_box', form[0]).show();
        addressFinder.modes[formid] = '';
    });

    $('.entry_postcode').typeahead({
        displayText: function (item) {
            return item.label;
        },
        source: function (query, process) {
            debouncedGetAddresses(urlForGettingAddressesByPostcode, query, process);
        },
        updater: function (item) {
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
        displayText: function (item) {
            return item.label;
        },
        source: function (query, process) {
            debouncedGetAddresses(urlForGettingAddressesBySuburb, query, process);
        },
        updater: function (item) {
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
});
@endpushonce


