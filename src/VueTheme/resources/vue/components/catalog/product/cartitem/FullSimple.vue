<template>
  <v-layout>
    <v-flex md3 xs3>
      <a :href="product_url">
        <v-img :src="catalogMediaUrl('product', product_image)" width="130" height="130"></v-img>
      </a>
    </v-flex>
    <v-flex class="v-middle" md6 xs6>
      <div>{{ item.name }}</div>
      <slot></slot>
      <a :href="product_url">Keep Shopping {{ item.name }}</a>
      <quantity-selector
        :max="20"
        v-if="quantitive"
        v-model="quantity"
        v-on:change="quantityChange"
      ></quantity-selector>
    </v-flex>
    <v-flex class="v-middle text-right" md2 xs3>
      ${{ item.row_price }}
      <v-btn icon @click="deleteCartItem(item)">
        <v-icon>mdi-delete</v-icon>
      </v-btn>
    </v-flex>
    <v-flex md1 xs0></v-flex>
  </v-layout>
</template>

<script>
import MiniSimple from "./MiniSimple";
export default {
  extends: MiniSimple,
  methods: {
    quantityChange() {
      this.$emit("quantityChange", {
        id: this.item.id,
        quantity: this.quantity,
      });
    },
  },
};
</script>
