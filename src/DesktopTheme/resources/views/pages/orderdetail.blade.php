@extends('customer.base')

{{--optional--}}
@section('title')
    <title>
        Alphazento | Order Detail
    </title>
@endsection


@section('customer')
    @if($order)
        <div class="pagecontent__main">
            <div class="column main">
                <ul class="items order-links clearfix">
                    <li class="nav item current"><strong>Items Ordered</strong></li>
                    {{--<li class="nav item"><a href="account-myorders-invoice.html">Invoices</a></li>--}}
                </ul>
                <div class="order-details-items ordered">
                    <div class="order-title">
                        <strong>Items Ordered</strong>
                    </div>
                    <div class="table-wrapper order-items table-responsive">
                        <table class="data table table-order-items" id="my-orders-table" summary="Items Ordered">
                            <caption class="table-caption">Items Ordered</caption>
                            <thead>
                            <tr>
                                <th class="col name">Product Name</th>
                                <th class="col price">Price</th>
                                <th class="col qty">Qty</th>
                                <th class="col subtotal">Subtotal</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->products as $product)
                            <tr>
                                <td class="col name" data-th="Product Name">
                                    <strong class="product name product-item-name">{{$product->getName(true) }}</strong>
                                </td>
                                <td class="col price" data-th="Price">
                                 <span class="price-excluding-tax" data-label="Excl. Tax">
                                 <span class="cart-price">
                                 <span class="price">{{ Sales::formatAsCurrency($product->final_price, true) }}</span> </span>
                                 </span>
                                </td>
                                <td class="col qty" data-th="Qty">
                                    <ul class="items-qty">
                                        <li class="item">
                                            <span class="content">{{ $product->products_quantity }}&nbsp;x&nbsp;</span>
                                        </li>
                                    </ul>
                                </td>
                                <td class="col subtotal" data-th="Subtotal">
                                 <span class="price-excluding-tax" data-label="Excl. Tax">
                                 <span class="cart-price">
                                 <span class="price">{{ Sales::formatAsCurrency($product->final_price * $product->products_quantity, true) }}</span> </span>
                                 </span>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            @foreach($order->feeCharges as $item)
                            <tr>
                                <th colspan="3" class="mark" scope="row">
                                    {!! $item->title !!}
                                </th>
                                <td>
                                    <span class="price">{{ $item->text }}</span>
                                </td>
                            </tr>
                            @endforeach
                            </tfoot>
                        </table>
                    </div>
                    <div class="actions-toolbar">
                        <div class="secondary">
                            <a class="action back" href="{{route('customer.account.orders')}}">
                                <span>Back to My Orders</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="block block-order-details-view">
                    <div class="block-title">
                        <strong>Order Information</strong>
                    </div>
                    <div class="block-content">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="box box-order-shipping-address">
                                    <strong class="box-title"><span>Delivery Address</span></strong>
                                    <div class="box-content">
                                        <address>{{$order->delivery_company}}<br>
                                            {{ $order->delivery_name }}<br>
                                            {{$order->delivery_street_address}}<br>
                                            {{$order->delivery_suburb}}<br>
                                            {{$order->delivery_city}}
                                            , {{$order->delivery_state}} {{$order->delivery_postcode}}
                                        </address>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="box box-order-billing-address">
                                    <strong class="box-title">
                                        <span>Invoice Address</span>
                                    </strong>
                                    <div class="box-content">
                                        <address>{{$order->billing_company}}<br>
                                            {{ $order->billing_name }}<br>
                                            {{$order->billing_street_address}}<br>
                                            {{$order->delivery_suburb}}<br>
                                            {{$order->billing_city}}
                                            , {{$order->billing_state}} {{$order->billing_postcode}}
                                        </address>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="box box-order-billing-method">
                                    <strong class="box-title">
                                        <span>Payment Method</span>
                                    </strong>
                                    <div class="box-content">
                                        @php
                                            $methods = Payment::getMethods();
                                            if(isset($methods[$order->payment_method])){
                                                $paymentName = $methods[$order->payment_method]->getTitle();
                                            }else{
                                                $paymentName =$order->payment_method ;
                                             }
                                        @endphp
                                       {{$paymentName}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block block-order-details-view">
                    <div class="block-title">
                        <strong>Handling History</strong>
                    </div>
                    <div>
                        @foreach($statuses as $history)
                            <div class="d-flex" style="line-height: 30px;">
                                <div class="pull-left" style="width: 50%;">
                                    {{ \Carbon\Carbon::parse($history['date_added'])->format('D,j M Y')}}
                                </div>
                                <div class="pull-right text-right" style="width: 50%;">
                                    {{ $history['status']}}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @else
        Sorry, order #{{$order_id}}# cannot be found.
    @endif
@endsection
