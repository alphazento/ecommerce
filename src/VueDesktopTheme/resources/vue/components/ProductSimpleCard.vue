<template>
  <v-hover v-slot:default="{ hover }">
    <v-card
      class="mx-auto"
    >
      <v-img
        :src="getProductImageUrl(product)"
        height="280px"
        contain
      >
      </v-img>
      <v-card-title class="title">
        <v-row
          class="fill-height flex-column"
          justify="space-between"
        >
          <p class="mt-4 subheading text-left">{{ product.sku }}</p>
          <div>
            <p class="ma-0 body-1 font-weight-bold font-italic text-left">
              ${{ product.price }}
            </p>
          </div>

          <div class="align-self-center">
            <v-btn class="btn__view" 
              :href="getProductUrl(product)"
            >
            View
            </v-btn>

            <v-btn icon class="wishlist-icon">
              <v-icon >
              mdi-heart
              </v-icon>
            </v-btn>
          </div>
        </v-row>
      </v-card-title>
    </v-card>
  </v-hover>
</template>

<script>
  var mixin = require('../mixin/catalogpollyfill')
  export default {
    mixins: [mixin.default],
    props: {
      product: {
        type: Object
      }
    }
  }
</script>


<style scoped>
.btn__view {
  color: #fff;
  background-color: #600BD2 !important;
}
.wishlist-icon {
  color:red !important;
}
</style>