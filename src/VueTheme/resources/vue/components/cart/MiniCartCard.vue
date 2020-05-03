<template>
  <v-card flat class="mx-auto">
    <v-toolbar flat color="#F2F2F2">
      <v-toolbar-title class="display-1">{{ cart.items_quantity }} Items</v-toolbar-title>
      <v-spacer />
      <v-tooltip right>
        <template v-slot:activator="{ on }">
          <v-btn icon v-on="on" @click="handleVModel">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </template>
        <span>Close</span>
      </v-tooltip>
    </v-toolbar>
    <v-container>
      <v-list-item three-line v-for="(item, idx) in cart.items" :key="idx">
        <v-list-item-avatar tile size="80">
          <v-img :src="catalogMediaUrl('product', item.product.image)" eager></v-img>
        </v-list-item-avatar>
        <v-list-item-content>
          <v-list-item-title>{{ item.name }}</v-list-item-title>
          <v-list-item-subtitle>
            <span class="text-uppercase">{{displayVariations(item)}}</span>
          </v-list-item-subtitle>
          <v-list-item-subtitle>${{ item.unit_price }} * {{item.quantity}}=${{ item.row_price }}</v-list-item-subtitle>
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
var mixin = require("../../mixin/catalogpollyfill");
export default {
  mixins: [mixin.default],
  props: {
    cart: {
      type: Object
    },
    value: Boolean
  },
  data() {
    return {
      closeDrawer: this.value
    };
  },
  methods: {
    displayVariations(cartItem) {
      if (cartItem.options) {
        var texts = [];
        let keys = Object.keys(cartItem.options);
        keys.forEach(name => {
          if (name != "actual_pid") {
            texts.push(`${name}:${cartItem.options[name]}`);
          }
        });
        return texts.length > 0 ? texts.join(" ") : "";
      }
      return "";
    },
    handleVModel() {
      this.closeDrawer = false;
      this.$emit("input", this.closeDrawer);
      this.$emit("change", this.closeDrawer);
    }
  }
};
</script>
