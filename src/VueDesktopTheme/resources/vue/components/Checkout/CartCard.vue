<template>
  <v-container>
    <v-card class="mx-auto" fill-width>
      <v-list-item two-line v-for="(item, idx) in cart.items" :key="idx">
        <v-list-item-avatar tile size="80">
          <v-img :src="getProductImageUrl(item.product)"></v-img>
        </v-list-item-avatar>
        <v-list-item-content>
          <v-container>
            <v-layout row>
              <v-flex md3 xs2></v-flex>
              <v-flex md4 xs5 class="v-middle">{{ item.name }}</v-flex>
              <v-flex md5 xs5 class="v-middle text-right">
                <v-btn icon>
                  <v-icon>mdi-delete</v-icon>
                </v-btn>
              </v-flex>
            </v-layout>
            <v-layout row>
              <v-flex md3 xs2></v-flex>
              <v-flex md4 xs5 class="v-middle">
                <qty-select :max="20" v-model="item.quantity" v-on:change="updateCartItemQty(item)"></qty-select>
              </v-flex>
              <v-flex md5 xs5 class="v-middle text-right">${{item.row_price}}</v-flex>
            </v-layout>
          </v-container>
        </v-list-item-content>
      </v-list-item>
      <hr />
      <v-card-actions>
        <v-container>
          <v-layout>
            <v-flex md6 xs6>
              <strong>Subtotal</strong>
            </v-flex>
            <v-flex md6 xs6>${{cart.total}}</v-flex>
          </v-layout>
          <v-layout>
            <v-flex md6 xs6>
              <strong>Shipping & Handling</strong>
            </v-flex>
            <v-flex md6 xs6>${{cart.handle_fee}}</v-flex>
          </v-layout>
        </v-container>
      </v-card-actions>
    </v-card>

    <hr />

    <v-layout>
      <v-expansion-panels accordion light>
        <v-expansion-panel>
          <v-expansion-panel-header>
            <strong>Have coupon</strong>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <v-form v-model="valid" lazy-validation>
              <v-text-field
                v-model="coupon_code"
                :rules="couponRules"
                label="Enter coupon code here"
                required
              ></v-text-field>
              <v-btn color="primary" :disabled="!valid">Apply</v-btn>
            </v-form>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
    </v-layout>
  </v-container>
</template>

<script>
var mixin = require("../../mixin/catalogpollyfill");
export default {
  mixins: [mixin.default],
  data() {
    return {
      valid: false,
      coupon_code: "",
      couponRules: [
        v => !!v || "Coupon code is required",
        v => (v && v.length <= 10) || "Name must be less than 10 characters"
      ]
    };
  },
  created() {
    if (this.cart) {
      this.coupon_code = this.cart.coupon_codes;
    }
  },
  computed: {
    cart() {
      return this.$store.state.cart;
    }
  },
  methods: {
    updateCartItemQty(item) {
      this.$store.dispatch("updateCartItemQty", item).then(
        response => {
          console.log("updateCartItemQty ", response);
        },
        error => {
          console.error(
            "Got nothing from server. Prompt user to check internet connection and try again"
          );
        }
      );
    }
  }
};
</script>

<style scoped>
.v-middle {
  margin-top: auto;
  margin-bottom: auto;
}
</style>