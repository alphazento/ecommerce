<template>
  <v-layout row>
    <v-flex md7 xs12>
      <v-card flat>
        <h1 class="display-2 text-uppercase text-center">{{ product.name }}</h1>
        <v-card-text>
          <v-img
            max-width="600px"
            style="margin-left: auto;margin-right: auto;"
            :src="product.image"
            eager
          ></v-img>
        </v-card-text>
      </v-card>
    </v-flex>
    <v-flex md5 xs12>
      <v-form method="POST" action="`/shoppingcart/products/${product.id}`">
        <v-card flat>
          <v-card-text class="font-weight-bold">
            <v-layout row>
              <slot name="price" v-bind:product="product">
                <div class="display-1" style="color:#F44336;">
                  ${{ product.price.price }}
                </div>
              </slot>
            </v-layout>
            <v-layout row>
              <slot name="description" v-bind:product="product">
                <p v-html="product.short_description" />
              </slot>
            </v-layout>
          </v-card-text>

          <v-card-actions>
            <input type="hidden" name="qty" v-model="selectedQty" />
            <quantity-selector
              :max="20"
              v-model="selectedQty"
            ></quantity-selector>
            <v-btn depressed large type="submit" class="btn__addtocart"
              >Add to Cart</v-btn
            >
          </v-card-actions>
        </v-card>
      </v-form>
    </v-flex>
  </v-layout>
</template>

<script>
export default {
  props: {
    product: {
      type: Object,
    },
    tabs: {
      type: Object,
    },
    showQutity: {
      type: Boolean,
    },
  },
  data() {
    return {
      selectedQty: 1,
      canShowQutity: this.showQutity ? true : false,
      canShowQutity: true,
      qtys: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
      model: "tab-physic",
    };
  },
  computed: {},
};
</script>
