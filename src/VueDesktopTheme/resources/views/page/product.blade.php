@extends('layout.frame', ['nav_page' => 'home'])

@push('head')
    <title>BaicyTek product</title>
@endpush

@section('pagecontent')
    <product-full-card :product="product" :tabs="detailTabs"></product-full-card>
@endsection

@push('tail')
    <script>
    const store = window.vStore.default;
    const app = new Vue({
        el: '#app',
        store,
        vuetify: new Vuetify(),
        data: {
            product: @json($product),
            detailTabs: @json($jsonFields)
        },
    });
    </script>
@endpush