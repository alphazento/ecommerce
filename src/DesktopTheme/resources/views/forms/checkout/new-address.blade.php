@extends('forms.base-full-address-form')

@section('addressModal_submitButton')
    <button data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving"
            data-normal-text="Save"
            type="button"
            class="btn btn-primary address-edit-form__save-btn disable-before-address-verify"
            value="{{$formId}}"
        >Save</button>
@endsection

@push('rqjs_configs')
    require_add_config('Noty', @asset("/tonercitytheme/assets/js/noty.min"), {
        deps: [],
        exports: 'Noty'
    });
@endpush
@push('rqjs_body')
    requirejs(['jQuery', 'windowLib', 'Noty'], function($, windowLib, Noty) {

        $('.address-edit-form__save-btn').click(function() {
            var $form = $("#" + this.value);
            var addressType = $form.attr('data-address-type');
            var modal = $(this).getModal();
            var $errorDiv = $form.siblings('.alert');
            var $button = $(this);

            $errorDiv.hide();

            $form.find('#address_type').val(addressType);
            if (!$form.length || !$form.valid()) {
                return false;
            }
            var data = $form.serialize();
            $.ajaxPOST('/ajax/quote/addresses', data,
                function(data) {
                    if (data.success) {
                        modal.modal('hide');
                        $form[0].reset();
                        windowLib.sendMessage('address-added', data['data']);
                    }
                },
                function(xhr) {

                    var $alertDiv = $errorDiv.find('.alert');
                    var errors = xhr.responseJSON.errors.validation;
                    var fields = Object.keys(errors);

                    $errorDiv.empty();

                    var $ul = $('<ul>').css({listStyle: 'disc', paddingLeft: '10px'});
                    fields.forEach(function(field) {
                        var fieldErrors = errors[field];
                        fieldErrors.forEach(function(fieldError) {
                            $('<li>').text(fieldError).appendTo($ul);
                        });
                    });
                    if ($ul.find('li').length) {
                        $errorDiv.append($ul).show();
                    }
                }
            );

        });
    });
@endpush
