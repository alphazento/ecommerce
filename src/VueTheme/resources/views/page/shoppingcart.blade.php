@extends('layout.frame', ['nav_page' => 'home'])

@push('head')
    <title>Shopping Cart</title>
@endpush

@section('pagecontent')
    <h1 class="index_h1">Shopping Cart</h1>
    <shopping-cart-card></shopping-cart-card>
@endsection

@push('tail')
    <script>
    const store = window.vStore.default;
    const app = new Vue({
        el: '#app',
        store,
        vuetify: new Vuetify(),
        data: {
          loaded: false,
          cart: @json($cart)
        },
        created() {
            this.$store.dispatch('QUOTE_SUCCESS', this.cart);
            this.loaded = true;
            window.hidePageLoader();
        }
    });
    </script>
@endpush
