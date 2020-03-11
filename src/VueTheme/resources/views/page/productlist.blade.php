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
    swatches: @json($swatches)
  },
  methods: {
    closeFilter() {
      console.log('closeFilter')
    }
  },
  created() {
      this.$store.dispatch('setUser', this.user);
  }
});
</script>
@endpush