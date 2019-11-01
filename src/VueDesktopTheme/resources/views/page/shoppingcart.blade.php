@extends('layout.frame', ['nav_page' => 'home'])

@push('head')
    <title>Shopping Cart</title>
@endpush

@section('pagecontent')
    <h1 class="index_h1">Shopping Cart</h1>
    @if($cart && $cart->items->count() > 0)
        <shopping-cart-card :cart="cart"></shopping-cart-card>
    @else
        <div class="empty-shopping-cart">
            <p class="title">Shopping Cart is Empty</p>
            <p>You have no items in your shopping cart.</p>
            <p>Click <a href="/">here</a> to continue shopping</p>
        </div>
    @endif
@endsection

@push('tail')
    <script>
    const app = new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        data: {
          cart: @json($cart)
        },
    });
    </script>
@endpush