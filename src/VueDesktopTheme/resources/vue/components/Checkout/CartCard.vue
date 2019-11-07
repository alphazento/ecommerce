<template>
  <v-container>
    <v-layout class="cart-row" v-for="(item, idx) in cart.items" :key="idx">
      <v-flex md12 xs12>
        <v-layout>
          <v-flex md3 xs3>
            <v-img :src="getProductImageUrl(item.product)" width="130" height="130"></v-img>
          </v-flex>
          <v-flex class="v-middle" md4 xs4>
            <a :href="getProductUrl(item.product)">{{ item.name }}</a>
          </v-flex>
          <v-flex class="v-middle" md2 xs3>
            <qty-select :max="20" v-model="item.quantity"></qty-select>
          </v-flex>
          <v-flex class="v-middle text-right" md2 xs2>${{ item.row_price }}</v-flex>
          <v-flex md1 xs0></v-flex>
        </v-layout>
        <v-layout>
          <v-flex md10 xs10></v-flex>
          <v-flex md2 xs2 text-center>
            <v-btn icon>
              <v-icon>mdi-delete</v-icon>
            </v-btn>
          </v-flex>
        </v-layout>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
var mixin = require("../../mixin/catalogpollyfill");
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
.cart-row {
    display: flex;
    flex-wrap: wrap;
    flex: 1 1 auto;
}
</style>