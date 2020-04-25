<template>
  <div>
    <v-list-item two-line v-for="(item, idx) in cart.items" :key="idx">
      <v-list-item-avatar tile size="80">
        <a :href="product_url">
          <v-img :src="catalogMediaUrl('product', product_image)"></v-img>
        </a>
      </v-list-item-avatar>
      <v-list-item-content>
        <v-list-item-title class="headline mb-1">
          {{ item.name }} * {{ item.quantity }}
          <cart-item-options-variation
            :product="item.product"
            :options="item.options"
          ></cart-item-options-variation>
        </v-list-item-title>
        <v-list-item-subtitle>${{ item.row_price }}</v-list-item-subtitle>
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
      type: Object,
    },
    productImage: {
      type: String,
    },
    notQuantitive: {
      type: Boolean,
    },
    productUrl: {
      type: String,
    },
  },
  data() {
    return {
      quantitive: !this.notQuantitive,
      product_image: this.productImage
        ? this.productImage
        : this.item.product.image,
      product_url: this.productUrl
        ? this.productUrl
        : this.getProductUrl(this.item.product),
    };
  },
};
</script>
