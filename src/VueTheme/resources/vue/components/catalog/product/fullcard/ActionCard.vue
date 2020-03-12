<template>
    <v-form ref="addtocart_form" method="POST" :action="`/shoppingcart/add_product/${product.id}`" lazy-validation @submit="submit">
        <v-card class="mx-auto" >
            <v-card-title>
                <h1 class="text-uppercase">
                    {{ product.name }}
                </h1>
            </v-card-title>
            <v-card-text>
                <slot name="content" v-bind:product="product"></slot>
            </v-card-text>
            <v-divider class="mx-4"></v-divider>
            <input type="hidden" name="qty" v-model="selectedQty" />
            <v-container>
                <slot name="actions" v-bind:product="product"></slot>
                <quantity-selector
                    v-if="!fixQuantity"
                    :max="20"
                    v-model="selectedQty"
                ></quantity-selector>
                <v-layout row>
                    <v-btn
                        depressed
                        large
                        class="btn__addtocart"
                        width="100%"
                        type="submit"
                        >
                        Add to Cart
                    </v-btn>
                </v-layout>
            </v-container>
        </v-card>
    </v-form>
</template>

<script>
export default {
    props: {
        product: {
            type: Object
        },
        fixQuantity: String|Number
    },
    data() {
        return {
            selectedQty: this.fixQuantity ? (0 + this.fixQuantity) : 1
        }
    },
    methods: {
        submit(e) {
            if (!this.$refs.addtocart_form.validate()) {
                e.preventDefault();
            }
        }
    }
};
</script>
