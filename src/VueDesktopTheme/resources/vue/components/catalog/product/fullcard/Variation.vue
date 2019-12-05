<template>
    <v-layout row>
        <v-flex md5 xs12>
            <v-carousel cycle
                :show-arrows="true"  
                height="500px"
                :hide-delimiter-background="true"
            >
                <v-carousel-item
                    v-for="(item, index) in variationElements.images"
                    :key="index"
                    reverse-transition="fade-transition"
                    transition="fade-transition"
                >
                <v-sheet height="100%" tile>
                    <v-row class="fill-height" align="center" justify="center">
                        <v-img
                            :src="getProductImageUrl(item)"
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
            <v-container>
                 <v-form
                    :action="`/shoppingcart/add_product/${product.id}`"
                    method="POST"
                >
                    <input type="hidden" name="options[actual_pid]" v-model="actual_pid"/>
                    <v-layout row>
                        <v-flex md1 xs1></v-flex>
                        <v-flex md10 xs10>
                            <h1 class="display-2 text-uppercase">
                                {{ product.desc.name }}
                            </h1>
                            <br/>
                            <p v-html="product.desc.description "></p>
                        </v-flex>
                    </v-layout>
                    <v-layout row>
                        <v-flex md1 xs1></v-flex>
                        <v-flex md10 xs10>
                            <product-swatches-card
                                :product="product"
                                @productElementsUpdated="productElementsUpdated"
                            ></product-swatches-card>
                        </v-flex>
                    </v-layout>
                    <v-layout row>
                        <v-flex md1 xs1></v-flex>
                        <v-flex md10 xs10>
                            <span class="display-1" style="color:#F44336;">
                                ${{ variationElements.priceRange[0] }}
                            </span>
                            <span class="display-1" style="color:#F44336;" v-if="variationElements.priceRange.length > 1">
                                to ${{ variationElements.priceRange[0] }}
                            </span>
                        </v-flex>
                    </v-layout>
                
                    <v-layout row>
                        <v-flex md1 xs1></v-flex>
                        <v-flex md6 xs6>
                            <qty-select
                                :max="20"
                                v-model="selectedQty"
                            ></qty-select>
                        </v-flex>
                        <input type="hidden" name="quantify" v-model="selectedQty" />
                        <v-flex md5 xs5>
                            <v-btn
                                depressed
                                large
                                class="btn__addtocart"
                                type="submit"
                                :disabled="variationElements.candidates.length != 1"
                                >Add to Cart</v-btn
                            >
                        </v-flex>
                    </v-layout>
                </v-form>
            </v-container>
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
                    this.product.prices.price
                ],
                candidates: [],
            },
            actual_pid: 0
        };
    },
    methods: {
        productElementsUpdated(elements) {
            this.variationElements = elements;
            if (this.variationElements.candidates.length > 0) {
                this.actual_pid = this.variationElements.candidates[0].id;
            } else {
                this.actual_pid = 0;
            }
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
