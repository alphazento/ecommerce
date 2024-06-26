@extends('layout.frame', ['nav_page' => 'products'])
@push('head')
    <title>Product List | Alphazento</title>
@endpush

@section('pagecontent')
<search-result-card :pagination="pagination" >
  <template>
    <category-filter-card></category-filter-card>
  </template>
</search-result-card>
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
    pagination: @json($pageData['products']),
    loaded: false
  },
  methods: {
    closeFilter() {
      console.log('closeFilter')
    }
  },
  created() {
      this.$store.dispatch('BIND_CUSTOMER', this.user);
      this.$store.dispatch('SET_PRODUCT_ATTR_CONTAINERS', @json($attrContainers));
      this.loaded = true;
      window.hidePageLoader();
  }
});
</script>
@endpush
