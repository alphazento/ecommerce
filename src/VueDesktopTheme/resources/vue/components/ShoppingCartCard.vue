<template>
  <v-container fluid>
    <v-layout>
      <v-flex md8 xs12>
        <v-layout>
          <v-flex md3>Item</v-flex>
          <v-flex md4>Description</v-flex>
          <v-flex md2>Quantity</v-flex>
          <v-flex md3>Subtotal</v-flex>
        </v-layout>

        <v-layout v-for="(item, idx) in cart.items" :key="idx" :href="`#tab-${idx}`">
          <v-flex md12>
            <v-layout>
              <v-flex md3>
                <v-img :src="getProductImageUrl(item.product)" width="130" height="130"></v-img>
              </v-flex>
              <v-flex class="v-middle" md4>
                <a :href="getProductUrl(item.product)">{{ item.name }}</a>
              </v-flex>
              <v-flex class="v-middle" md2>
                <strong class="product-quantity">× {{ item.quantity }}</strong>
              </v-flex>
              <v-flex class="v-middle" md3>${{ item.row_price }}</v-flex>
            </v-layout>
            <v-layout>
              <v-flex md10></v-flex>
              <v-flex md2>
                <v-btn icon>
                  <v-icon>mdi-delete</v-icon>
                </v-btn>
              </v-flex>
            </v-layout>
          </v-flex>
        </v-layout>
      </v-flex>

      <v-flex md4 xs12>
        <v-layout>
          <h2>Summary</h2>
        </v-layout>
        <v-layout>
          <v-flex md6 xs6>Cart Subtotal:</v-flex>
          <v-flex md6 xs6>${{cart.subtotal}}</v-flex>
        </v-layout>
        <v-layout>
          <v-flex md6 xs6>Shipping &amp; Handling:</v-flex>
          <v-flex md6 xs6>${{cart.shipping_fee}}</v-flex>
        </v-layout>
        <v-layout>
          <v-flex md6 xs6>Order Total:</v-flex>
          <v-flex md6 xs6>${{cart.total}}</v-flex>
        </v-layout>
        <v-layout>
          <v-flex md12 xs12>
            <v-btn large color="purple" class="white--text" :href="'/checkout'">Proceed to Checkout</v-btn>
          </v-flex>
        </v-layout>
      </v-flex>
    </v-layout>
  </v-container>
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
.v-middle {
  margin-top: auto;
  margin-bottom: auto;
}
</style>