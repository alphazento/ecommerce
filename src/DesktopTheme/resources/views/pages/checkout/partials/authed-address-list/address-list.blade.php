<?php
    $visible = $type === 'delivery' || $type === 'invoice' && !$quoteSnapshot->isSameAddress();
?>
<div style="display: {{ $visible ? 'block' : 'none' }}" id="osc__{{ $type }}-address-container">
    <div class="row">
        <div class="col-12">
            <h6 class="osc__h6">{{ ucfirst($type) }} Address</h6>
                <div id="{{ $type }}-address-part">
                @for ($i =0; $i < 20; $i++)
                    <div id="{{ $type }}-address-block-{{$i}}" class="form-group osc__address-block shadow-sm" style="display:none;">
                        <input class="{{ $type }}-address-selector osc__input-radio"
                               type="radio"
                               name="{{ $type }}address_id"
                               id="{{ $type }}-address-radio-{{ $i }}"
                               value="{{ $i }}">
                        <label class="osc__address-info" for="{{ $type }}-address-radio-{{ $i }}">
                            <strong class="address-fullname"></strong>
                        </label>
                        <p class="phone-number"></p>
                        <p class="address-company-name"></p>
                        <p><span class="address-street1"></span><span class="address-street2"></span></p>
                        <p class="address-extra"></p>
                    </div>
                @endfor
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">
            <button type="button" class="btn osc__btn-orange" id="{{ $type }}-address-modal">Add New Address</button>
        </div>
    </div>
</div>

@push('rqjs_body')
    requirejs(['jQuery', 'windowLib'], function($, windowLib) {
        $('#{{ $type }}-address-modal').click(function(){
            var $addressModal = $('#addressModal');
            $form = $addressModal.find('form');
            $form.attr('data-address-type', '{{ $type }}');
            $addressModal.modal('toggle');
        });
    });
@endpush
