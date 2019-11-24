@extends('layout.frame', ['nav_page' => 'products', 'appjs' => 'routeapp.js'])
@push('head')
    <title>BaicyTek Home page</title>
@endpush

@section('pagecontent')
<router-link :to="{ name:'search',query: { queryId: 1 }}" >
     router-link跳转Query
</router-link>

<router-view>
</router-view>
<!-- 
<search-result-card>
  <template>
    <category-filter-card></category-filter-card>
  </template>
</search-result-card> -->
@endsection

@push('tail')
<script>
const store = window.vStore.default;
const router = new VueRouter({
    mode: 'history',
    routes: [
        { name:"search", path: '/search', component: SearchResultRoutePage }
    ]
});
const app = new Vue({
  el: '#app',
  store,
  vuetify: new Vuetify(),
  router: router,
  data: {
    pagination: @json($pagination)
  },
  created() {
    this.$store.dispatch('assignSearchResult', this.pagination)
  }
});
</script>
@endpush