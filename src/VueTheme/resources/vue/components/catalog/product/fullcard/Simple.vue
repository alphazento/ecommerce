<template>
    <v-layout row>
        <v-flex md5 xs12>
            <v-img max-width="400px" :src="getProductImageUrl(product)"></v-img>
        </v-flex>
        <v-flex md7 xs12>
            <h1 class="display-2 text-uppercase">
                {{ product.name }}
            </h1>
            <br/>
            <p v-html="product.description"/>
            <!-- <product-tab
                :description="product.desc.description"
                :flex="'md9 xs12'"
            ></product-tab> -->
            <v-content>
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
                        <v-flex md6 xs6 v-if="canShowQutity">
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
        },
        showQutity: {
            type: Boolean
        }
    },
    data() {
        return {
            selectedQty: 1,
            canShowQutity: this.showQutity ? true : false,
            qtys: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
            model: "tab-physic"
        };
    }
};
</script>
