@extends('layout.frame', ['nav_page' => 'products'])
@push('head')
    <title>BaicyTek Home page</title>
@endpush

@section('pagecontent')
<div id="app" >
    <section id="page_wrap">
        @include('widget.catetorylist')
        <div class="page_cr">
            <h2 class="page_cr_h2">Product List</h2>
            <div class="pp_wrap_c">
            <product-list :api-url="api_eps.product_list" :pageable="true" :pagination="pagination"></product-list>
            </div>
        </div>
    </section>
</div>
<script>
const app = new Vue({
  el: '#app',
  // mixins: [mixin],
  data: {
    pagination: @json($pageData['products']),
    api_eps: @json($api_eps)
  },
});
</script>
@endsection