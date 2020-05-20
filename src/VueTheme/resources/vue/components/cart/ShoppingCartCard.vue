<template>
  <v-container>
    <v-layout class="row" v-if="quoteIsEmpty">
      <v-flex md12 text-center>
        <div class="empty-shopping-cart">
          <p class="title">Shopping Cart is Empty</p>
          <p>You have no items in your shopping cart.</p>
          <p>
            Click
            <a href="/">here</a> to continue shopping
          </p>
        </div>
      </v-flex>
    </v-layout>
    <v-layout class="row" v-else>
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
          v-for="(item, idx) in quote.items"
          :key="idx"
          :href="`#tab-${idx}`"
        >
          <v-flex md12 xs12>
            <component
              :is="cartItemComponent(item)"
              v-bind="{ item: item }"
              @quantityChange="updateCartItemQty"
            ></component>
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
          <v-flex md6 xs6>${{ quote.subtotal }}</v-flex>
        </v-layout>
        <v-layout>
          <v-flex md6 xs6>Shipping &amp; Handling:</v-flex>
          <v-flex md6 xs6>${{ quote.shipping_fee }}</v-flex>
        </v-layout>
        <v-layout>
          <v-flex md6 xs6>Order Total:</v-flex>
          <v-flex md6 xs6>${{ quote.total }}</v-flex>
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
import { mapGetters } from "vuex";

var mixin = require("../../mixin/catalogpollyfill");

export default {
  mixins: [mixin.default],
  computed: {
    ...mapGetters(["quote", "quoteIsEmpty"])
  },
  methods: {
    cartItemComponent(item) {
      switch (item.product.morph_type) {
        case "configurable":
          return "full-cart-item-configurable";
          break;
        case "downloadable":
          return "full-cart-item-downloadable";
          break;
        case "simple":
          return "full-cart-item-simple";
          break;
      }
    },
    updateCartItemQty(item) {
      this.$store.dispatch("UPDATE_QUOTE_ITEM_QTY_REQUEST", item);
    },
    deleteCartItem(item) {
      this.$store.dispatch("DELETE_QUOTE_ITEM_REQUEST", item.id);
    }
  }
};
</script>
