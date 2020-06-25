@extends('layout.frame', ['nav_page' => 'products', 'appjs' => 'routeapp.js'])
@push('head')
    <title>{{$page_data['title']}}</title>
@endpush

@section('pagecontent')
  <router-view>
  </router-view>
@endsection

@push('tail')
<script>
const store = window.vStore.default;
const router = new VueRouter({
    mode: 'history',
    routes: [
        {
          name:"search",
          path: "/{{ $path }}",
          component: SearchResultRoutePage,
          props: { pageData: @json($page_data) }
        }
    ]
});
const app = new Vue({
  el: '#app',
  store,
  vuetify: new Vuetify(),
  router: router,
  created() {
    this.$store.dispatch('CATALOG_SEARCH_SUCCESS', @json($pagination));
    this.$store.dispatch('SET_PRODUCT_ATTR_CONTAINERS', @json($attrContainers));
  }
});
</script>
@endpush
