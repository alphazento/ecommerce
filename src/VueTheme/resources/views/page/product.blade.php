@extends('layout.frame', ['nav_page' => 'home'])

@push('head')
    <title>{{$product->name}}  | Alphazento</title>
@endpush

@section('pagecontent')
@include('widget.breadcrumbs')
<v-container fluid>
    <v-layout row>
        <v-flex md8 xs12 >
            <z-product-image-carousel :images="images"></z-product-image-carousel>
        </v-flex>
        <v-flex md4 xs12>
            <z-product-action-card :product="product" :fix-quantity="product.model_type=='downloadable' ? 1 : 0">
                <template v-slot:content>
                    <z-product-review-bullet :product="product"></z-product-review-bullet>
                    <z-product-price-bullet :product="product" :price="price"></z-product-price-bullet>
                    <z-product-stock-bullet :product="product"></z-product-stock-bullet>
                    <z-product-shipping-bullet :product="product"></z-product-shipping-bullet>
                    <z-configurable-product-bullet v-if="product.model_type=='configurable'"
                        :product="product" 
                        @update_images="updateImages" 
                        @update_price="updatePrice">
                    </z-configurable-product-bullet>
                </template>
            </z-product-action-card>
        </v-flex>
    </v-layout>
    <v-layout row>
        <v-flex md8 xs12>
            <product-tabs :product="product" :product-tabs="tabs">
                <template v-slot:extra-tab-headers="{product}">
                    <v-tab href="#extra-tab-review">
                        Product Review
                    </v-tab>
                </template>
                <template v-slot:extra-tabs="{product}">
                    <v-tab-item value="extra-tab-review">
                        <div>
                            Be the first to review.
                        </div>
                    </v-tab-item>
                </template>
            </product-tabs>
        </v-flex>
        <v-flex md8 xs12>
        </v-flex>
    </v-layout>
</v-container>
@endsection

@push('tail')
<script>
    const store = window.vStore.default;
    const app = new Vue({
        el: '#app',
        store,
        vuetify: new Vuetify(),
        data() {
            let product = @json($product->toArray());
            return {
                user: @json($user),
                product: product,
                tabs: @json($tabs),
                detailTabs: @json($jsonFields),
                swatches: @json($swatches),
                price: product.price.final_price,
                images: [product.image]
            }
        },
        created() {
            this.$store.dispatch('setUser', this.user);
            this.$store.dispatch('setSwatches', this.swatches);
        },
        methods: {
            updateImages(images) {
                this.images = images.map(item => {
                    return item.image;
                })
            },
            updatePrice(price) {
                this.price = price;
            }
        }
    });
</script>
@endpush