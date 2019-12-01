@extends('layout.frame', ['nav_page' => 'home'])

@push('head')
    <title>BaicyTek product</title>
@endpush

@section('pagecontent')
<v-container fluid>
    <component 
    :is="productCard"
    v-bind="{ product: product }"></component>
   <product-tabs :tabs="detailTabs" :product="product"></product-tabs>
</v-container>
@endsection

@push('tail')
    <script>
    const store = window.vStore.default;
    const app = new Vue({
        el: '#app',
        store,
        vuetify: new Vuetify(),
        data: {
            product: @json($product->toArray()),
            detailTabs: @json($jsonFields),
            swatches: @json($swatches),
            productCard: 'full-simple-product-card'
        },
        created() {
            switch(this.product.type_id) {
                case 'simple':
                    this.productCard = 'full-simple-product-card';
                    break;
                case 'configuable':
                    this.productCard = 'full-variation-product-card';
                    break;
            }
        }
    });
    </script>
@endpush