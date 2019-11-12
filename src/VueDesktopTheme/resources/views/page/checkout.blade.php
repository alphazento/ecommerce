@extends('layout.frame', ['nav_page' => 'home'])

@push('head')
    <title>Checkout</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCe1exctmeJjIb4guyT6newSpyJ7kA3aLc&libraries=places"></script>
@endpush

@section('pagecontent')
    <h1 class="index_h1">Checkout</h1>
    <checkout-main-card :cart="cart"></checkout-main-card>
@endsection

@push('tail')
    <script>
    const store = window.vStore.default;
    const app = new Vue({
        el: '#app',
        store,
        vuetify: new Vuetify(),
        data: {
          cart: @json($cart),
          paymentmethods: @json($paymentmethods)
        },
        created() {
            this.$store.dispatch('initConsts', {paymentmethods: this.paymentmethods });
        }
    });
    </script>
@endpush