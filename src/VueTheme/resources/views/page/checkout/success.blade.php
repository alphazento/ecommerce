@extends('layout.frame', ['nav_page' => 'checkout'])

@push('head')
    <title>Order Confirmed</title>
@endpush

@section('pagecontent')
    <v-layout class="row">
        <v-flex md12 text-center>
            <h1 class="index_h1">Your order
                <a href="/">{{ $order_number }} </a>
                has been placed.
            </h1>
            <p>
                Click
                <a href="/">here</a> to continue shopping
            </p>
        </v-flex>
    </v-layout>
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
          cart: {}
        },
        created() {
            this.$store.dispatch('updateCart', this.cart);
            this.$store.dispatch('setUser', window.appData.user);
        }
    });
    </script>
@endpush
