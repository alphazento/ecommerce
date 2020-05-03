<template>
  <v-hover v-slot:default="{ hover }">
    <v-card class="mx-auto">
      <a :href="getProductUrl(product)">
        <v-img :src="catalogMediaUrl('product', product.image)" height="280px" contain eager>
          <v-container fill-height fluid>
            <v-layout fill-height>
              <v-flex xs12 align-end flexbox></v-flex>
            </v-layout>
          </v-container>
        </v-img>
      </a>

      <v-card-title>
        <div class="mx-5">
          <p class="title blue--text">{{ product.name }}</p>
          <br />
          <v-rating readonly small dense background-color="orange" color="orange" v-model="rating"></v-rating>
          <span class="title">${{ product.price.final_price }}</span>
          <div v-show="product.price.price != product.price.final_price">
            &nbsp
            <del class>${{ product.price.price }}</del>
          </div>
        </div>
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
  },
  data() {
    return {
      rating: 3,
      color: "grey lighten-2"
    };
  }
};
</script>
