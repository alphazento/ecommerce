@extends('layout.frame', ['nav_page' => 'home'])

@push('head')
    <title>Checkout</title>
    <script src={{sprintf("https://maps.googleapis.com/maps/api/js?key=%s&libraries=places", config("google.place.api.key"))}}></script>
@endpush

@section('pagecontent')
    <h1 class="index_h1">Checkout</h1>
    <spinner-layer></spinner-layer>
    @if($user->guest())
    <checkout-guest-card :cart="cart">
        <template v-slot:sns_login>
            @stub('sns_login')
        </template>
    </checkout-guest-card>
    @else
    <checkout-authed-card :cart="cart">
    </checkout-authed-card>
    @endif
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
        },
        created() {
            this.$store.dispatch('updateCart', this.cart);
            this.$store.dispatch('setUser', window.appData.user);
        }
    });
    </script>
@endpush
