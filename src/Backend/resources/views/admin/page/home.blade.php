@extends('admin.layout.frame')

@section('pagecontent')
    <router-view>
    </router-view>
@endsection

@push('admin.tail')
<script>
const store = window.vStore.default;
const router = new VueRouter({
    mode: 'history',
    routes: [
    ]
});
const app = new Vue({
  el: '#app',
  store,
  vuetify: new Vuetify(),
  router: router,
  data: {
  
  },
  created() {
   
  }
});
</script>
@endpush