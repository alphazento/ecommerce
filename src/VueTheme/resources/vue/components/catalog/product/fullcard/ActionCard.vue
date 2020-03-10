<template>
    <v-form method="POST" :action="`/shoppingcart/add_product/${product.id}`">
        <v-card class="mx-auto my-12">
            <v-card-title>
                <h1 class="text-uppercase">
                    {{ product.name }}
                </h1>
            </v-card-title>
            <v-card-text>
                <z-product-review-bullet :product="product"></z-product-review-bullet>
                <z-product-price-bullet :product="product"></z-product-price-bullet>
                <z-product-stock-bullet :product="product"></z-product-stock-bullet>
                <z-product-shipping-bullet :product="product"></z-product-shipping-bullet>
            </v-card-text>
            <v-divider class="mx-4"></v-divider>
            <v-card-actions>
                <input type="hidden" name="qty" v-model="selectedQty" />
                <qty-select
                    :max="20"
                    v-model="selectedQty"
                    max-width="50%"
                ></qty-select>
                <v-btn
                    depressed
                    large
                    type="submit"
                    class="btn__addtocart"
                    width="50%"
                    >
                    Add to Cart
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-form>
</template>

<script>
export default {
    props: {
        product: {
            type: Object
        }
    },
    data() {
        return {
            selectedQty: 1
        }
    }
};
</script>
