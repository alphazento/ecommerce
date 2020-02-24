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
            user: @json($user),
            product: @json($product->toArray()),
            detailTabs: @json($jsonFields),
            swatches: @json($swatches),
            productCard: 'full-simple-product-card'
        },
        created() {
            console.log('product', this.product);
            this.$store.dispatch('setUser', this.user);
            this.$store.dispatch('setSwatches', this.swatches);
            switch(this.product.model_type) {
                case 'simple':
                    this.productCard = 'full-simple-product-card';
                    break;
                case 'configurable':
                    this.productCard = 'full-configurable-product-card';
                    break;
                case 'downloadable':
                    this.productCard = 'full-downloadable-product-card';
                    break;
            }
        }
    });
    </script>
@endpush