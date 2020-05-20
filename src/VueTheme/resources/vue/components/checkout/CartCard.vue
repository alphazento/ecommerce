<template>
  <div>
    <v-card class="mx-auto" fill-width>
      <v-list-item two-line v-for="(item, idx) in quote.items" :key="idx">
        <v-list-item-avatar tile size="80">
          <v-img :src="catalogMediaUrl('product', item.product.image)" eager></v-img>
        </v-list-item-avatar>
        <v-list-item-content>
          <v-container>
            <v-layout row>
              <v-flex md3 xs2></v-flex>
              <v-flex md4 xs5 class="v-middle">{{ item.name }}</v-flex>
              <v-flex md5 xs5 class="v-middle text-right">
                <v-btn icon @click="deleteCartItem(item)">
                  <v-icon>mdi-delete</v-icon>
                </v-btn>
              </v-flex>
            </v-layout>
            <v-layout row>
              <v-flex md3 xs2></v-flex>
              <v-flex md4 xs5 class="v-middle">
                <quantity-selector
                  :max="20"
                  v-model="item.quantity"
                  v-on:change="updateCartItemQty(item)"
                ></quantity-selector>
              </v-flex>
              <v-flex md5 xs5 class="v-middle text-right">${{ item.row_price }}</v-flex>
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
            <v-flex md6 xs6>${{ quote.total }}</v-flex>
          </v-layout>
          <v-layout>
            <v-flex md6 xs6>
              <strong>Shipping & Handling</strong>
            </v-flex>
            <v-flex md6 xs6>${{ quote.handle_fee }}</v-flex>
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
  </div>
</template>

<script>
import { mapGetters } from "vuex";

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
    if (this.quote) {
      this.coupon_code = this.quote.coupon_codes;
    }
  },
  computed: {
    ...mapGetters(["quote"])
  },
  methods: {
    updateCartItemQty(item) {
      this.$store.dispatch("updateCartItemQty", item).then(response => {
        console.log("updateCartItemQty ", response);
      });
    },
    deleteCartItem(item) {
      this.$store.dispatch("deleteCartItem", item).then(response => {
        console.log("deleteCartItem", response);
      });
    }
  }
};
</script>
