@extends('customer.base')

<!-- optional -->
@section('title')
    <title>
        Alphazento | Re-Order
    </title>
@endsection


@section('customer')

    <div class="pagecontent__main">
        <div class="block-dashboard mb-4">

            <div>
                <div class="row">

                    <div class="col-sm-10">
                        <div class="block-dashboard__title"><h1>Re-Order</h1></div>
                    </div>
                    <div class="col-sm-2">
                        <div class="text-right">

                            <select name="date-range" id="date-range" class="form-control"
                                    data-placeholder="Filter by Date Range">
                                <option value="all">All</option>
                                @foreach($dateRanges as $key => $dateRange)
                                    <option value="{{ $dateRange['from'] }},{{ $dateRange['to'] }}" {{ $selectedDateRange == $dateRange['from'] . ','. $dateRange['to'] ? 'selected' : '' }}>{{ $key }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row" style="line-height: 30px;">
                <div class="col-sm-12">
                    <span>Total: {{ $orders->total() }} (items) 10 Per Page</span>
                </div>
            </div>
            <div class="row" style="line-height: 50px;">
                <div class="col-sm-12">
                    {!! $orders->appends(['dateRange' => $selectedDateRange])->links('customer.partials.pagination') !!}
                </div>
            </div>
            <hr>
            <div>

                @if ($orders->total())
                    @foreach($orders as $order)
                        <div id="{{ $order->orders_id }}">
                            <b style="font-size: 16px;">Order #{{ $order->orders_number }}, purchased on {{ $order->date_purchased }}</b>
                        </div>

                        @foreach($order->products as $product)
                            @php
                                $product = $product->current;
                                if(!$product) {
                                    continue;
                                }
                            @endphp

                            <div class="row mb-4">
                                <div class="col-xs-12" style="width: 100%;">
                                    <div class="card">
                                        <div class="card-body">
                                            <ul>
                                                @include('components.product-component',['product'=>$product])
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                @else
                    <p>No orders placed in this time period.</p>
                @endif

                @if($hasGuestOrders)
                    <div>
                        * There're some orders checkouted by guest mode with your email address.
                        <a href="{{route('verification.notice')}}">Validate</a> your email address to see all your orders.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection


@push('rqjs_body')
    requirejs(["jQuery"], function ($) {
        $('#date-range').on('change', function () {
            if ($(this).val() == 'all') {
                window.location = window.location.pathname;
            } else {
                window.location = window.location.pathname + '?dateRange=' + $(this).val();
            }
        });

        $(document).ready(function ($) {
            var url = window.location.href;
            if (url.indexOf("#") > 0) {
                var hash = url.substring(url.indexOf("#") + 1);
                console.log(hash);
                $('#' + hash).addClass('blue-highlight');
            }
        });
    });
@endpush
