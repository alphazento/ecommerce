<template>
  <div>
    <v-list-item two-line v-for="(item, idx) in cart.items" :key="idx">
        <v-list-item-avatar tile size="80">
          <v-img :src="productImage"></v-img>
        </v-list-item-avatar>
        <v-list-item-content>
          <v-list-item-title class="headline mb-1">
            {{ item.name }} * {{item.quantity}}
            <cart-item-options-variation :product="item.product" :options="item.options"></cart-item-options-variation>
          </v-list-item-title>
          <v-list-item-subtitle>${{item.row_price}}</v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>
  </div>
</template>

<script>
var mixin = require("../../../../mixin/catalogpollyfill");
export default {
  mixins: [mixin.default],
  props: {
    item: {
      type: Object
    },
    productImage: {
      type: String
    }
  },
  data() {
    return {
      product_image: this.productImage ? this.productImage : this.getProductImageUrl(this.item.product)
    }
  }
};
</script>