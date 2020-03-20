@extends('admin.layout.frame')

@section('pagecontent')
    <z-dialog-container></z-dialog-container>
    <router-view>
    </router-view>
@endsection

@push('admin.tail')
@php
$logo = config(\Zento\StoreFront\Consts::LOGO);
@endphp
<script>
const store = window.vStore.default;
const router = window.router;
window.eventBus = new Vue();

const app = new Vue({
  el: '#app',
  store,
  vuetify: new Vuetify(),
  router: router,
  created() {
    this.$store.dispatch('SET_THEME_DATA', @json(['logo'=>$logo]));
    this.$store.dispatch('AXIOS_AUTH_INTERCEPTOR', this.$router);
  }
});
</script>
@endpush