@extends('customer.base')

@section('php')
    <?php
        $defaultBillingAddress = Customer::now()->getDefaultBillingAddress();
        $defaultDeliveryAddress = Customer::now()->getDefaultDeliveryAddress();
        $default_billing_addr_id = empty($defaultBillingAddress) ? 0 : $defaultBillingAddress->getId();
        $default_delivery_addr_id = empty($defaultDeliveryAddress) ? 0 : $defaultDeliveryAddress->getId();
    ?>
@endsection

@section('title')
    <title>
        Alphazento | Edit Account Information
    </title>
@endsection


@section('customer')
    <div class="pagecontent__main">
        <div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="block-dashboard__title"> <h1>Address Entries</h1></div>
                </div>
                <div class="col-sm-6">
                    <div class="text-right">
                        <button type="button" class="btn-sm btn-success address-modal__btn"
                            data-toggle="modal"
                            data-target="#addressModal"
                            value="0"
                            mode="add"
                            >Add NEW Address
                        </button>
                    </div>
                </div>
            </div>

            <div>
                @foreach(Customer::now()->addresses ?? [] as $key=> $addr)
                <div class="row">
                    <div class="col-xs-12"  style="width: 100%;">
                        <div class="card">
                            <div class="card-body">
                                <ul>
                                    @include('components.address-component',['addr'=>$addr,'index'=>$key+1,'type'=>2,'default_billing_addr_id'=>$default_billing_addr_id, 'default_delivery_addr_id' => $default_delivery_addr_id])
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                @endforeach
            </div>
        </div>
    </div>

@endsection

@push('footer')
    @include('components.modal-component', [
        'title' => 'New Address',
        'refId' => 'addressModal',
        'contentTemplate' => 'forms.address-edit-form',
        'fade' => true,
        'large' => true,
    ])
    @include('components.confirm-modal-component')
@endpush

@push('rqjs_body')
setGlobalConfigKeyValue('addresses', @json(Customer::now()->addresses));
requirejs(['jQuery', 'windowLib'], function($, windowLib) {
    windowLib.onMessage('addresses-added', function(newAddress) {
        window.location.reload();
    });
})
@endpush
