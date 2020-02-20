<template>
    <v-hover v-slot:default="{ hover }">
        <v-card class="mx-auto">
            <a :href="getProductUrl(product)">
                <v-img
                    :src="getProductImageUrl(product)"
                    height="280px"
                    contain
                ></v-img>
            </a>
            <v-card-title class="title">
                <v-container>
                    <p class="mt-4 text-left">{{ product.name }}</p>
                    <p
                        class="ma-0 subheading body-1 font-weight-bold text-left"
                    >
                        ${{ product.prices.price }}
                    </p>
                </v-container>
            </v-card-title>
        </v-card>
    </v-hover>
</template>

<script>
var mixin = require("../../../../mixin/catalogpollyfill");
export default {
    mixins: [mixin.default],
    props: {
        product: {
            type: Object
        }
    }
};
</script>
