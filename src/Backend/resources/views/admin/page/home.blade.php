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
  data: {
    component: null
  },
  created() {
      this.$store.dispatch('setThemeData', @json(['logo'=>$logo]));
  }
});
</script>
@endpush