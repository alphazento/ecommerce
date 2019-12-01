<template>
    <v-hover v-slot:default="{ hover }">
        <v-card
            light
            outlined
            class="mx-auto"
            :color="hover ? '#EEEEEE' : '#FFFFFF'"
        >
            <v-carousel
                :show-arrows-on-hover="true"
                :hide-delimiters="true"
                :hide-delimiter-background="true"
                height="280px"
            >
                <a :href="getProductUrl(product)">
                    <v-carousel-item
                        v-for="(item, index) in variationElements.images"
                        :key="index"
                        reverse-transition="fade-transition"
                        transition="fade-transition"
                    >
                        <v-sheet height="100%" tile light>
                            <v-row
                                class="fill-height"
                                align="center"
                                justify="center"
                                height="280px"
                            >
                                <v-img
                                    :src="getProductImageUrl(item)"
                                    height="280px"
                                    contain
                                >
                                    <v-container fill-height fluid>
                                        <v-layout fill-height>
                                            <v-flex xs12 align-end flexbox>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                </v-img>
                            </v-row>
                        </v-sheet>
                    </v-carousel-item>
                </a>
            </v-carousel>

            <v-card-title>
                <div class="mx-5">
                    <p class="title blue--text">{{ product.desc.name }}</p>
                    <br />
                    <v-rating
                        readonly
                        small
                        dense
                        background-color="orange"
                        color="orange"
                        v-model="rating"
                    ></v-rating>
                    <span class="title"> ${{ product.prices.price }}</span>
                    &nbsp
                    <del class=""> ${{ product.prices.rrp }}</del>
                </div>
            </v-card-title>
            <v-card-actions class="text-center">
                <product-swatches-card
                    :product="product"
                    @productElementsUpdated="productElementsUpdated"
                ></product-swatches-card>
            </v-card-actions>
            <!-- <v-card-actions>
          <v-btn large rounded depressed class="mx-auto add-cart-btn" >ADD TO CART</v-btn>
        </v-card-actions> -->
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
    },
    data() {
        return {
            rating: 3,
            color: "grey lighten-2",
            variationElements: {
                images: [],
                priceRange: [
                    this.product.prices.price,
                    this.product.prices.price
                ]
            }
        };
    },
    methods: {
        productElementsUpdated(elements) {
            console.log("elements", elements);
            this.variationElements = elements;
        }
    }
};
</script>
