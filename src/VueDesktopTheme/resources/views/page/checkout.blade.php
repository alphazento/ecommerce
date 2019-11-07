@extends('layout.frame', ['nav_page' => 'home'])

@push('head')
    <title>Checkout</title>
@endpush

@section('pagecontent')
    <h1 class="index_h1">Checkout</h1>
    <checkout-main-card :cart="cart"></checkout-main-card>
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