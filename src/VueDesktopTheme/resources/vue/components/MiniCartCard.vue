<template>
  <v-card class="mx-auto" max-width="344" max-height="400">
    <v-card-text>{{cart.items_quantity}} Items</v-card-text>

    <v-container class="limit-height">
      <v-list-item two-line v-for="(item, idx) in cart.items" :key="idx">
        <v-list-item-avatar tile size="80">
          <v-img :src="getProductImageUrl(item.product)"></v-img>
        </v-list-item-avatar>
        <v-list-item-content>
          <v-list-item-title class="headline mb-1">{{ item.name }} * {{item.quantity}}</v-list-item-title>
          <v-list-item-subtitle>${{item.row_price}}</v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>
    </v-container>

    <v-card-actions>
      <v-layout text-center>
        <v-flex md6 xs6>
          <v-btn color="blue-grey" class="ma-2 white--text" :href="'/shoppingcart'">View Cart</v-btn>
        </v-flex>
        <v-flex md6 xs6>
          <v-btn color="info" class="ma-2" :href="'/checkout'">Checkout</v-btn>
        </v-flex>
      </v-layout>
    </v-card-actions>
  </v-card>
</template>

<script>
var mixin = require("../mixin/catalogpollyfill");
export default {
  mixins: [mixin.default],
  props: {
    cart: {
      type: Object
    }
  }
};
</script>

<style scoped>
.limit-height {
  max-height: 300px;
  overflow-y: scroll;
}
.title {
  background: #cdd4fc none repeat scroll 0 0;
  font: bold 14px/20px "Open Sans", Arial, Helvetica, sans-serif;
  padding: 9px 10px 11px;
  text-align: center;
  text-transform: uppercase;
}
.v-middle {
  margin-top: auto;
  margin-bottom: auto;
}
.cart-row {
  display: flex;
  flex-wrap: wrap;
  flex: 1 1 auto;
}
</style>