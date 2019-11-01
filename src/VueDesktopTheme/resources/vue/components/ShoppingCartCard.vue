<template>
  <v-container fluid >
    <v-layout row>
      <v-flex md9 xs12>
        <v-layout row>
            <v-flex md3>
                Item
            </v-flex>
            <v-flex md4>
                Description
            </v-flex>
            <v-flex md1>
                Quantity
            </v-flex>
            <v-flex md3>
                Subtotal
            </v-flex>
        </v-layout>

        <v-layout v-for="(item, idx) in cart.items" :key="idx" :href="`#tab-${idx}`">
            <v-flex md3>
                <v-img :src="getProductImageUrl(item)" width="130" height="130"></v-img>
            </v-flex>
            <v-flex class="v-middle" md4>
                <a :href="getProductUrl(item)">{{ item.name }}</a>
            </v-flex>
            <v-flex class="v-middle" md1>
                <strong class="product-quantity"> × {{ item.quantity }}</strong>
            </v-flex>
            <v-flex class="v-middle" md3>
                ${{ item.row_price }}
            </v-flex>
        </v-layout>
      </v-flex>

      <v-flex md3 xs12>
          <v-layout row>
              <h2>Summary</h2>
          </v-layout>
          <v-layout row>
            <v-flex md4 xs4>
              Cart Subtotal:
            </v-flex>
             <v-flex md8 xs8>
              ${{cart.subtotal}}
            </v-flex>
          </v-layout>
          <v-layout row>
            <v-flex md4 xs4>
              Shipping &amp; Handling:
            </v-flex>
             <v-flex md8 xs8>
              ${{cart.shipping_fee}}
            </v-flex>
          </v-layout>
          <v-layout row>
            <v-flex md4 xs4>
              Order Total:
            </v-flex>
             <v-flex md8 xs8>
              ${{cart.total}}
            </v-flex>
          </v-layout>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
  var mixin = require('../mixin/catalogpollyfill')
  export default {
    mixins: [mixin.default],
    props: {
      cart: {
        type: Object
      }
    }
  }
</script>

<style scoped>
.v-middle {
  margin-top:auto;
  margin-bottom:auto;
}
</style>