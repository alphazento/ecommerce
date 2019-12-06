<template>
  <v-container>
    <v-layout class="row" v-if="cart && cart.items && cart.items.length > 0">
      <v-flex md8 xs12>
        <v-layout class="cart-row">
          <v-flex md3 xs3>Item</v-flex>
          <v-flex md4 xs4>Description</v-flex>
          <v-flex md2 xs3>Quantity</v-flex>
          <v-flex md2 xs2 text-right>Subtotal</v-flex>
          <v-flex md1 xs0></v-flex>
        </v-layout>

        <v-layout
          class="cart-row"
          v-for="(item, idx) in cart.items"
          :key="idx"
          :href="`#tab-${idx}`"
        >
          <v-flex md12 xs12>
            <full-cart-item-simple :item="item"></full-cart-item-simple>
            <v-layout>
              <v-flex md10 xs10></v-flex>
              <v-flex md2 xs2 text-center>
                <v-btn icon @click="deleteCartItem(item)">
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

    <v-layout class="row" v-if="!cart || cart.items.length == 0">
      <v-flex md12 text-center>
        <div class="empty-shopping-cart">
            <p class="title">Shopping Cart is Empty</p>
            <p>You have no items in your shopping cart.</p>
            <p>Click <a href="/">here</a> to continue shopping</p>
        </div>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
var mixin = require("../../mixin/catalogpollyfill");
import { mapState } from "vuex";
export default {
  mixins: [mixin.default],
  computed: {
    cart() {
      return this.$store.state.cart;
    }
  },
  methods: {
    updateCartItemQty(item) {
      this.$store.dispatch("updateCartItemQty", item).then(response => {
        console.log("updateCartItemQty ", response);
      });
    },
    deleteCartItem(item) {
      this.$store.dispatch("deleteCartItem", item).then(response => {
        console.log("deleteCartItem ", response);
      });
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