<template>
    <v-layout row>
        <v-flex md5 xs12>
            <v-carousel
                :show-arrows-on-hover="true"
                :hide-delimiters="true"
                :hide-delimiter-background="true"
                height="280px"
            >
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
            </v-carousel>
        </v-flex>
        <v-flex md7 xs12>
            <h1 class="display-2 text-uppercase">
                {{ product.desc.name }}
            </h1>
            <product-detail
                :description="product.desc.description"
                :flex="'md9 xs12'"
            ></product-detail>
            <v-content>
                <v-layout row>
                    <product-swatches-card
                        :product="product"
                        @productElementsUpdated="productElementsUpdated"
                    ></product-swatches-card>
                </v-layout>
                <v-layout row>
                    <v-flex md1 xs1></v-flex>
                    <v-flex md6 xs6>
                        <div class="display-1" style="color:#F44336;">
                            ${{ product.prices.price }}
                        </div>
                    </v-flex>
                </v-layout>
                <v-form
                    :action="`/shoppingcart/add_product/${product.id}`"
                    method="POST"
                >
                    <v-layout row>
                        <v-flex md1 xs1></v-flex>
                        <v-flex md6 xs6>
                            <qty-select
                                :max="20"
                                v-model="selectedQty"
                            ></qty-select>
                        </v-flex>
                        <input type="hidden" name="qty" v-model="selectedQty" />
                        <v-flex md5 xs5>
                            <v-btn
                                depressed
                                large
                                class="btn__addtocart"
                                type="submit"
                                >Add to Cart</v-btn
                            >
                        </v-flex>
                    </v-layout>
                </v-form>
            </v-content>
        </v-flex>
    </v-layout>
</template>

<script>
var mixin = require("../../../../mixin/catalogpollyfill");
export default {
    mixins: [mixin.default],
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
            model: "tab-physic",
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

<style scoped>
.btn__addtocart {
    color: #fff;
    background-color: #600bd2 !important;
    margin: 5px 5px;
}
</style>
