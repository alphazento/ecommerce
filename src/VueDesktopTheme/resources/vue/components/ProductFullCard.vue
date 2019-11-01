<template>
  <v-container fluid >
      <v-layout row>
        <v-flex md5 xs12>
          <v-img :src="getProductImageUrl(product)"></v-img>
        </v-flex>
        <v-flex md7 xs12>
          <h1 class="display-2 text-uppercase">{{product.sku}}</h1>
            <product-detail :description="product.description" :flex="'md9 xs12'"></product-detail>
          <v-content>
            <v-layout row>
              <v-flex md1 xs1></v-flex>
              <v-flex md6 xs6>
                <div class="display-1" style="color:#F44336;">
                  ${{product.price}}
                </div>
              </v-flex>
            </v-layout>
            <v-layout row>
              <v-flex md1 xs1></v-flex>
              <v-flex md6 xs6>
                <v-select
                  :items="qtys"
                  label="Quantity"
                  outlined
                ></v-select>
              </v-flex>
              <v-flex md5 xs5>
                <v-btn depressed large class="btn__addtocart">
                  Add to Cart
                </v-btn>
              </v-flex>
            </v-layout>
          </v-content>
        </v-flex>
      </v-layout>
      <v-layout row>
        <v-tabs
          v-model="model"
          background-color=" accent-4"
          center-active
          centered
          dark
        >
          <v-tab v-for="(tab, idx) in tabs" :key="idx" :href="`#tab-${idx}`">{{tab}}</v-tab>
        </v-tabs>
        <v-tabs-items v-model="model">
          <v-tab-item
            v-for="(tab, idx) in tabs" :key="idx"
            :value="`tab-${idx}`"
          >
            <product-detail :description="product[idx]" :flex="'md12 xs12'"></product-detail>
          </v-tab-item>
      </v-tabs-items>
      </v-layout>
  </v-container>
</template>

<script>
  var mixin = require('../mixin/catalogpollyfill')
  export default {
    mixins: [mixin.default],
    props: {
      product: {
        type: Object
      },
      tabs: {
        type: Object
      }
    },
    data() {
      return {
        qtys: [
          1,2,3,4,5,6,7,8,9,10
        ],
        model: 'tab-physic',
      }
    }
  }
</script>


<style scoped>
.btn__addtocart {
  color: #fff;
  background-color: #600BD2 !important;
  margin: 5px 5px;
}
</style>