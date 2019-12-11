@extends('layout.frame', ['nav_page' => 'products', 'appjs' => 'routeapp.js'])
@push('head')
    <title>{{$page_data['title']}}</title>
@endpush

@section('pagecontent')
  <spinner-layer></spinner-layer>
  <router-view>
  </router-view>
@endsection

@push('tail')
<script>
const store = window.vStore.default;
const router = new VueRouter({
    mode: 'history',
    routes: [
        { name:"search", path: "/{{ $path }}", component: SearchResultRoutePage }
    ]
});
const app = new Vue({
  el: '#app',
  store,
  vuetify: new Vuetify(),
  router: router,
  data: {
    pagination: @json($pagination),
    swatches: @json($swatches),
    pageData: @json($page_data)
  },
  created() {
    this.$store.dispatch('assignSearchResult', this.pagination);
    this.$store.dispatch('setSwatches', this.swatches);
    this.$store.dispatch('setPageData', this.pageData);
  }
});
</script>
@endpush