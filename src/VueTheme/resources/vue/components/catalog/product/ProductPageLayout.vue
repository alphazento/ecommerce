<template>
    <v-container>
        <v-layout row>
            <v-flex md8 xs12>
                <v-card flat>
                    <v-card-text>
                        <z-product-image-carousel :images="[product.image]"></z-product-image-carousel>
                    </v-card-text >
                </v-card>
            </v-flex>
            <v-flex md4 xs12>
                <z-product-action-card :product="product"></z-product-action-card>
            </v-flex>
        </v-layout>
        <v-layout row>
            <v-flex md8 xs12>
                <product-tabs>
                </product-tabs>
            </v-flex>
            <v-flex md8 xs12>
            </v-flex>
        </v-layout>
        <slot name="addons" v-bind:product="product"></slot>
    </v-container>
</template>

<script>
export default {
    props: {
        product: {
            type: Object
        },
        tabs: {
            type: Object
        }
    },
    data() {
        return {
            selectedQty: 1,
            qtys: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
            model: "tab-physic"
        };
    }
};
</script>
