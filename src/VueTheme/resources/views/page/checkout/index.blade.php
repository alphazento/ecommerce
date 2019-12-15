@extends('layout.frame', ['nav_page' => 'home'])

@push('head')
    <title>Checkout</title>
    <script src={{sprintf("https://maps.googleapis.com/maps/api/js?key=%s&libraries=places", config("google.place.api.key"))}}></script>
@endpush

@section('pagecontent')
    <h1 class="index_h1">Checkout</h1>
    <spinner-layer></spinner-layer>
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
          user: @json($user),
          cart: @json($cart),
          paymentmethods: @json($paymentmethods)
        },
        created() {
            this.$store.dispatch('initConsts', { paymentmethods: this.paymentmethods });
            this.$store.dispatch('updateCart', this.cart);
            this.$store.dispatch('setUser', this.user);
        }
    });
    </script>
@endpush