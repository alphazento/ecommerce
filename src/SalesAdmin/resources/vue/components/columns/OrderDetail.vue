<template>
  <v-container>
    <v-list-item two-line v-for="(item, idx) in products" :key="idx">
      <v-list-item-avatar tile size="80">
        <v-img :src="getProductImageUrl(item.product)"></v-img>
      </v-list-item-avatar>
      <v-list-item-content>
        <v-list-item-title class="mb-1">
          {{ item.name }} * {{item.quantity}}
          <!-- <cart-item-options-variation :product="item.product" :options="item.options"></cart-item-options-variation> -->
        </v-list-item-title>
        <v-list-item-subtitle>${{item.row_price}}</v-list-item-subtitle>
      </v-list-item-content>
    </v-list-item>
    <hr />
    <div v-for="(item, idx) in items" :key="idx">
      <span>{{ item.name }}:</span>
      <span>${{ item.total }}</span>
    </div>
  </v-container>
</template>

<script>
export default {
  props: {
    extraData: {
      products: Array,
      items: Array
    }
  },
  data() {
    return {
      products: this.extraData.products ? this.extraData.products : [],
      items: this.extraData.items ? this.extraData.items : []
    };
  },
  watch: {
    extraData(nV, oV) {
      this.products = this.extraData.products ? this.extraData.products : [];
      this.items = this.extraData.items ? this.extraData.items : [];
    }
  },
  methods: {
    getProductUrl: function(product) {
      if (product) {
        return `/${product.url_key}.html`;
      }
      return "#";
    },

    getProductImageUrl: function(product, relativePath) {
      if (product) {
        relativePath = relativePath || "/images/catalog/product";
        return `${relativePath}/${product.image}`;
      }
      return "not-found.png";
    }
  }
};
</script>
