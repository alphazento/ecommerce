@extends('forms.address-form')

@section('addressModal_submitButton')
    <button id="save-or-update-address"
            form="address_form"
            data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving"
            class="btn btn-primary">Save
    </button>
@endsection
