@extends('admin.layout.frame')

@section('pagecontent')
    <z-dialog-container></z-dialog-container>
    <router-view>
    </router-view>
@endsection

@push('admin.tail')
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
  }
});
</script>
@endpush