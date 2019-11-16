@extends('customer.base')

@section('customer')
    <div class="pagecontent__main">
        <div class="box-info">
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
                        @foreach ($orders->items() as $index=>$order)
                            <tr>
                                <td>#{{ $order->orders_number }}</td>
                                <td>{{ $order->date_purchased }}</td>
                                <td>{{ $order->delivery_street_address}}  {{$order->delivery_suburb}},  {{$order->delivery_state}} {{$order->delivery_postcode}}</td>
                                <td>{{ Sales::formatAsCurrency(Sales::getOrderTotal($order), true) }}</td>
                                <td>{{ isset($statusMap[$order->orders_status]) ? $statusMap[$order->orders_status] : 'Unknown'}}</td>
                                <td><a class="box-info__anchor" href="{{ route('sales.order.view', ['order_id'=>$order->orders_id]) }}">View Order</a>
                                @if (Sales::canReorder())
                                    |
                                    <a class="box-info__anchor" href="/customer/reorder/jump?index={{$index+1}}&&order_id={{$order->orders_id}}">
                                        Reorder
                                    </a>
                                @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="clearfix">
                <span>Total: {{ $orders->total() }} (items) 25 Per Page</span>
                {!! $orders->links('customer.partials.pagination') !!}
            </div>
            @if($hasGuestOrders)
            <div>
                * There're some orders checkouted by guest mode with your email address.
                <a href="{{route('verification.notice')}}">Validate</a> your email address to see all your orders.
            </div>
            @endif
        </div>
    </div>
@endsection
