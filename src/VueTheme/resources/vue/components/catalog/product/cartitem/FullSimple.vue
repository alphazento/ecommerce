<template>
  <v-layout>
    <v-flex md3 xs3>
      <a :href="product_url">
        <v-img :src="product_image" width="130" height="130"></v-img>
      </a>
    </v-flex>
    <v-flex class="v-middle" md4 xs4>
      <div>{{ item.name }}</div>
      <slot></slot>
      <a :href="product_url">Keep Shopping {{ item.name }}</a>
    </v-flex>
    <v-flex class="v-middle" md2 xs3>
      <qty-select :max="20" v-if="quantitive" v-model="item.quantity" v-on:change="quantityChange"></qty-select>
    </v-flex>
    <v-flex class="v-middle text-right" md2 xs2>${{ item.row_price }}</v-flex>
    <v-flex md1 xs0></v-flex>
  </v-layout>
</template>

<script>
import MiniSimple from "./MiniSimple";
export default {
  extends: MiniSimple,
  methods: {
    quantityChange() {
      this.$emit("quantityChange", this.item);
    }
  }
};
</script>
