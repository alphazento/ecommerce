@extends('layout.frame', ['nav_page' => 'products'])
@push('head')
    <title>BaicyTek Home page</title>
@endpush

@section('pagecontent')
<search-result-card>
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
    pagination: @json($pagination)
  },
  created() {
    this.$store.dispatch('assignSearchResult', this.pagination)
  }
});
</script>
@endpush