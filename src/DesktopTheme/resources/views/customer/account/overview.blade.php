@extends('customer.base')

@section('php')
    @php
        $subscriptions = Customer::now()->getSubscriptions();
        $defaultBillingAddr = Customer::now()->getDefaultBillingAddress();
        $defaultAddrId = Customer::now()->getDefaultBillingAddressId();
    @endphp
@endsection

@section('customer')
    <div class="pagecontent__main">
        <div class="box-info">
            <div class="box-info__title">
                <span class="float-left box-info__title--size2">Recent Orders</span>
                <a class="float-right box-info__anchor--white" href="{{route('customer.account.orders')}}">View All</a>
            </div>
            <div class="clearfix">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Order Number</th>
                            <th scope="col">Date</th>
                            <th scope="col">Ship To</th>
                            <th scope="col">Order Total</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($recentOrders as $order)
                            <tr>
                                <td>
                                    <a href="{{ route('sales.order.view', ['order_id'=>$order->orders_id]) }}">{{$order->orders_number}}</a>
                                </td>
                                <td>
                                    <time>{{ $order->date_purchased }}</time>
                                </td>
                                <td> {{$order->delivery_street_address}}  {{$order->delivery_suburb}}
                                    , {{$order->delivery_state}} {{$order->delivery_postcode}}</td>
                                <td>{{ Sales::formatAsCurrency(Sales::getOrderTotal($order), true)}}</td>
                                <td> {{ isset($statusMap[$order->orders_status]) ? $statusMap[$order->orders_status]:'Unknown'}}</td>
                                <td>
                                    <a class="box-info__anchor" href="{{ route('sales.order.view', ['order_id'=>$order->orders_id]) }}">
                                        View Order
                                    </a>
                                    @if (Sales::canReorder())
                                    <a href="{{ url('/customer/reorder#'. $order->orders_id) }}">
                                        Reorder
                                    </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    @if($hasGuestOrders)
                    <div>
                        * There're some orders checkouted by guest mode with your email address.
                        <a href="{{route('verification.notice')}}">Validate</a> your email address to see all your orders.
                    </div>
                    @endif
                </div>
            </div>
        </div>


        <div class="block-dashboard mb-4">
            <div class="block-dashboard__title">
                <h2>Account Information</h2>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="box-info">
                        <div class="box-info__title">
                            Contact Information
                        </div>
                        <div class="box-info__content">
                            <ul>
                                <li>
                                    {{ Customer::now()->getFirstName() }} {{ Customer::now()->getLastName() }}
                                </li>
                                <li>
                                    {{ Customer::now()->getEmail() }}
                                </li>
                                <li>
                                    <a class="box-info__anchor" href="{{ route('customer.account.information') }}">Edit</a> <span class="box-info__seperater">|</span> <a class="box-info__anchor" href="{{ route('customer.account.information') }}">Change Password</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box-info">
                        <div class="box-info__title">
                            Newsletters
                        </div>
                        <div class="box-info__content">
                            <ul>

                                @if( isset($subscriptions['newsletter']))
                                    @if($subscriptions['newsletter'] ==1)
                                        You subscribe to our newsletter.<br/>
                                    @else
                                        <li>You don't subscribe to our newsletter.</li>
                                    @endif
                                @else
                                    <li>You don't subscribe to our newsletter.</li>
                                @endif
                                <li>
                                    <a class="box-info__anchor" href="{{ route('customer.account.newsletter') }}">Edit</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="block-dashboard">
            <div class="block-dashboard__title clearfix">
                <h2 class="float-left">Address Book</h2>
                <a class="box-info__anchor float-right" href="{{ route('customer.account.addresses') }}">Manage Addresses</a>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="box-info">
                        <div class="box-info__title">
                            Default Address
                        </div>
                        <div class="box-info__content">
                            <ul>
                                @if (!empty($defaultBillingAddr))
                                    <li>{{ $defaultBillingAddr->getFirstName() }}</li>
                                    <li>{{ $defaultBillingAddr->getLastName() }}</li>
                                    <li>{{ $defaultBillingAddr->getStreet1() }}</li>
                                    <li>{{ $defaultBillingAddr->getStreet2() }}</li>
                                    <li>{{ $defaultBillingAddr->getState() }}
                                        ,{{ $defaultBillingAddr->getPostalCode() }}</li>
                                    <li> T: {{ Customer::now()->getTelephone() }}</li>
                                    <li>
                                    <span class="box-info__anchor"
                                          style="cursor: pointer;"
                                          data-toggle="modal"
                                          data-target="#addressModal"
                                          id="editAddress"
                                          mode="edit"
                                          address-id="{{ $defaultAddrId }}">
                                        Edit Address</span>
                                </li>
                                @else
                                    <li> You have not set a default invoice address.</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    @include('components.modal-component',[
               'title'=>'Edit Address',
               'refId'=>'addressModal',
               'contentTemplate'=>'forms.address-edit-form',
               'fade' => true,
               'large'=> true
           ])
@endsection
@pushonce('overview', 'rqjs_body')
    setGlobalConfigKeyValue('addresses', @json(Customer::now()->addresses));
    requirejs(['jQuery', 'windowLib'], function($, windowLib) {
        $('#editAddress').click(function() {
            windowLib.sendMessage('address-modal-data-init', {address_id: $(this).attr('address-id'), mode: $(this).attr('mode'), modal:"#addressModal"});
        });
        windowLib.onMessage('addresses-added', function(newAddress) {
            window.location.reload();
        });
    })
@endpushonce

