@extends('layouts.3columns')


@section('custom')
    <div class="container">
        <div class="row mt-4 mb-4">
            <div class="col-12">
                <div class="p-3 mb-2 bg-light text-success">
                    <p><i class="fa fa-check"></i> Your order number is: {{ $order->orders_number }}. We will email you an order confirmation with details.</p>
                </div>
                <div>
                    <a class="btn btn-primary" href="{{ route('home') }}" role="button">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
@endsection
