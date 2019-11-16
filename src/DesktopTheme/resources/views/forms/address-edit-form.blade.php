@extends('forms.base-full-address-form')

@section('addressModal_submitButton')
    <button data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving"
            data-normal-text="Save"
            type="button"
            class="btn btn-primary address-edit-form__save-btn disable-before-address-verify"
            value="{{$formId}}"
        >Save</button>
@endsection

@push('rqjs_body')
    requirejs(['jQuery', 'windowLib'], function($, windowLib) {
        var addresses = getGlobalConfigValue('addresses');

        $('.address-edit-form__save-btn').click(function() {

            $(this).html($(this).data('loading-text')).prop('disabled', true);

            var $me = $(this);
            var form = $("#" + this.value);
            var addressType = form.attr('data-address-type');
            if (!form.length || ! form.valid()) {
                $(this).html($(this).data('normal-text')).prop('disabled', false)
                return false;
            }
            var data = form.serialize();
            var modal = $(this).getModal();
            $.ajax({
                type: "POST",
                url: "{{ route('saveaddress') }}",
                data: data,
                dataType: 'json',
                success: function (data) {
                    if (!data.success) {
                        modal.displayMessage(data.errors);
                    } else {
                        windowLib.sendMessage('addresses-added', {'detail': data.address, 'type': addressType});
                    }
                },
                error: function (xhr, status, error) {
                    modal.displayMessage(error);
                    $(me).html($(me).data('normal-text')).prop('disabled', false);
                }
            });
        });

        var getAddressById = function(id) {
            for(var i=0; i < addresses.length; i++) {
                if (addresses[i]["address_book_id"] == id) {
                    return addresses[i];
                }
            }
        };

        windowLib.onMessage("address-modal-data-init", function(data) {
            var modal = $(data['modal']);
            switch(data['mode']) {
                case 'add':
                    modal.setModalTitle('Add New Address');
                    windowLib.sendMessage('init-address-form');
                    break;
                case 'edit':
                    modal.setModalTitle('Edit Address');
                    windowLib.sendMessage('init-address-form', {address: getAddressById(data['address_id'])});
                    break;
            }
        });

        windowLib.onMessage('address-confirm-init', function(data) {
            switch(data['mode']) {
                case 'delete':
                    $.ajaxDELETE('/customer/addresses/' + data['address_id'], {}, function(data) {
                        if(data.success){
                           window.location.reload();
                        }
                    });
                    break;
                case 'default_billing':
                    $.ajaxPUT('/customer/address/default/' + data['address_id'] + '/type/billing', {}, function(data) {
                        if(data.success){
                            window.location.reload();
                        }
                    });
                    break;
                case 'default_delivery':
                    $.ajaxPUT('/customer/address/default/' + data['address_id'] + '/type/delivery', {}, function(data) {
                        if(data.success){
                            window.location.reload();
                        }
                    });
                    break;
            }
        });
    });
@endpush
