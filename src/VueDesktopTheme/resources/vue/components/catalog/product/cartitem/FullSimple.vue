<template>
  <v-layout>
    <v-flex md3 xs3>
      <v-img :src="product_image" width="130" height="130"></v-img>
    </v-flex>
    <v-flex class="v-middle" md4 xs4>
      <a :href="product_image">{{ item.name }}</a>
      <slot></slot>
    </v-flex>
    <v-flex class="v-middle" md2 xs3>
      <qty-select :max="20" v-model="item.quantity" v-on:change="updateCartItemQty"></qty-select>
    </v-flex>
    <v-flex class="v-middle text-right" md2 xs2>${{ item.row_price }}</v-flex>
    <v-flex md1 xs0></v-flex>
    </v-layout>
</template>

<script>
import MiniSimple from "./MiniSimple"
export default {
  extends: MiniSimple,
  methods: {
    updateCartItemQty() {
      this.$emit('updateCartItemQty', this.item);
    }
  }
};
</script>