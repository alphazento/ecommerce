<template>
  <v-hover v-slot:default="{ hover }">
     <v-card class="mx-auto">
        <a  :href="getProductUrl(product)">
          <v-img :src="getProductImageUrl(product)" height="280px" contain>
              <v-container fill-height fluid>
                <v-layout fill-height>
                  <v-flex xs12 align-end flexbox>
                  </v-flex>
                </v-layout>
              </v-container>
          </v-img>
        </a>
            
        <v-card-title>
          <div class="mx-5">
            <span class="title blue--text">{{product.name}}</span><br>
            <v-rating readonly small dense background-color="orange" color="orange" v-model="rating"></v-rating>
            <span class="title"> ${{product.price}}</span> &nbsp <del class=""> ${{product.rrp}}</del>
          </div>
        </v-card-title>
        <v-card-actions>
          <v-btn large rounded depressed class="mx-auto add-cart-btn" >ADD TO CART</v-btn>
        </v-card-actions>
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
  data()  {
    return {
      rating: 3,
      color:"grey lighten-2",
    }
  }
};
</script>

<style scoped>
.add-cart-btn {
  color: #fff;
  background-color: #600bd2 !important;
}
.wishlist-icon {
  color: red !important;
}
</style>