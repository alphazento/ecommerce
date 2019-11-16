@push('styles')
    .address__form{
        margin-bottom: 40px
    }
@endpush
<form role="form" class="modal-address__validater address__form" id="{{$formId}}">
    <div>
        <div class="row">
            <div class="col-sm-12">
                <h3> Contact Details</h3>
            </div>

            <input name="address_manager_type"
                   id="address_manager_type"
                   class="form-control"
                   type="hidden">

            <input name="address_type" id="address_type" type="hidden">

            <input name="address_book_id"
                   id="address_book_id"
                   class="form-control"
                   type="hidden">
            <div class="col-sm-12">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>First Name <span class="required">*</span></label>
                        <input name="entry_firstname"
                               id="entry_firstname"
                               class="form-control"
                               placeholder="First Name" required
                               value="" type="text">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Last Name <span class="required">*</span></label>
                        <input name="entry_lastname"
                               id="entry_lastname"
                               class="form-control "
                               placeholder="Last Name" required
                               value="" type="text">
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Company(Optional)</label>
                        <input name="entry_company"
                               id="entry_company"
                               value=""
                               class="form-control "
                               placeholder="Business Name (Optional)"
                               type="text">
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <h3 class=font-16"> Address Details</h3>
            </div>

            <div class="col-sm-12">
                <div class="col-sm-12">
                    <div class="form-group">
                        <div id="full_address_box" style="display: block;">
                            <div class="form-group mc-reg-grp">
                                <label>Address Lookup <span class="required">*</span></label>
                                <input name="full_address"
                                       id="full_address" required
                                       class="form-control mc-reg-txtbox typeahead-full-address"
                                       placeholder="Start typing your address"
                                       autocomplete="disable">
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="details_address" class="col-sm-12" style="display:none;">
                <div class="col-sm-12">
                    <button class="switch_back_to_address_lookup">  Switch back to address lookup </button>
                    <div class="form-group">
                        <label>Street Address 1 <span class="required">*</span></label>
                        <input name="entry_street_address"
                               id="entry_street_address"
                               class="form-control "
                               placeholder="House number and street name" required
                               value=""
                               type="text">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Street Address 2</label>
                        <input name="entry_suburb"
                               id="entry_suburb"
                               class="form-control "
                               placeholder="Apartment, suite, unit etc. (optional)"
                               value="" type="text">
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Suburb <span class="required">*</span></label>
                        <input name="entry_city"
                               id="entry_city" required
                               value=""
                               autocomplete="disable"
                               data-id=""
                               class="form-control"
                               placeholder="Suburb">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>State <span class="required">*</span></label>
                        <select class="form-control "
                                name="entry_state"
                                id="entry_state" required>
                            @foreach(Customer::loadStates() as $state)
                                <option value="{{ $state }}">{{ $state }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Postcode <span class="required">*</span></label>
                        <input name="entry_postcode"
                               id="entry_postcode"
                               required value=""
                               data-id=""
                               maxlength="4"
                               minlength="4"
                               class="form-control"
                               placeholder="Postcode"
                               autocomplete="disable">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Country <span class="required">*</span></label>
                        <input value="Australia" readonly="" name="country"
                               type="text"
                               class="form-control "
                               placeholder="Country">
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>

@pushonce('address-form', 'rqjs_body')
requirejs(['jQuery', 'windowLib', 'jquery.validate'], function($, windowLib) {
    var addressFormValidation = {
        rules: {
            entry_firstname: {
                maxlength: 30,
                required: true
            },
            entry_lastname: {
                maxlength: 30,
                required: true
            },
            entry_company: {
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
            postcode: {
                digits: true
            }
        },
        messages: {
            entry_firstname: {
                required: 'Please enter your first name.'
            },
            lastname: {
                required: 'Please enter your last name.'
            },
            postcode: {
                required: 'Please choose/enter your postcode',
                minlength: 'Please enter 4 digits for postcode'
            },
            city: {
                required: 'Please choose/enter your suburb.'
            },
            state: 'Please select a state'
        }
    };
    $(".modal-address__validater").validate(addressFormValidation);

    windowLib.onMessage('init-address-form', function(data) {
        var form = $(".address__form");
        if (data !== undefined) {
            var formData = {
                address_book_id: data['address_book_id'],
                entry_company: data['entry_company'],
                entry_firstname: data['entry_firstname'],
                entry_lastname: data['entry_lastname'],
                entry_street_address: data['entry_street_address'],
                entry_postcode: data['entry_postcode'],
                entry_city: data['entry_city'],
                full_address: data['entry_street_address'] + " " + data['entry_suburb'] +
                    ", " + data['entry_city'] +
                    " " + data['entry_state'] +
                    " " + data['entry_postcode']
            }

            var keys = Object.keys(formData);
            for (var i = 0; i < keys.length; i++) {
                var box = $("[name='" + keys[i] + "']", form[0]);
                if (box.length) {
                    box.val(formData[keys[i]]);
                }
            }
        } else {
            form[0].reset();
        }
    });
         
});
@endpushonce

@include('components.typeahead-address',
    [
        'postcode' => 'entry_postcode',
        'suburb' => 'entry_city',
        'state' => 'entry_state',
        'fullAddress' => 'full_address',
        'streetAddress1' => 'entry_street_address',
        'streetAddress2' => 'entry_suburb',
        'detailsAddressBox'=>'details_address',
        'fullAddressBox'=>'full_address_box'
    ])
