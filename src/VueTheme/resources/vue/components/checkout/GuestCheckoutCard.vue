<template>
  <v-container>
    <v-layout class="row" v-if="quoteIsEmpty">
      <v-flex md12 text-center>
        <div class="empty-shopping-cart">
          <p class="title">Shopping Cart is Empty</p>
          <p>You have no items in your shopping cart.</p>
          <p>
            Click
            <a href="/">here</a> to continue shopping
          </p>
        </div>
      </v-flex>
    </v-layout>
    <v-layout class="row" v-else>
      <v-flex md4 xs12>
        <checkout-cart-card></checkout-cart-card>
      </v-flex>

      <v-flex md8 xs12>
        <v-stepper v-model="step" vertical>
          <v-stepper-step :complete="step > 1" step="1" class="step-header-container">
            <v-layout class="step-header">
              <v-flex md8>Contact Details</v-flex>
              <v-flex v-if="step > 1" md4 class="text-right">
                <a @click="step = 1">Edit</a>
              </v-flex>
            </v-layout>
            <small>Email, Name</small>
          </v-stepper-step>
          <v-stepper-content :step="1">
            <checkout-contact-card
              :complete="step > 1"
              :step="1"
              v-on:childMessage="getChildMessage"
            >
              <template>
                <slot name="sns_login"></slot>
              </template>
            </checkout-contact-card>
          </v-stepper-content>

          <v-stepper-step :complete="step > 2" step="2" class="step-header-container">
            <v-layout class="step-header">
              <v-flex md8>Delivery Address</v-flex>
              <v-flex v-if="step > 2" md4 class="text-right">
                <a @click="step = 2">Edit</a>
              </v-flex>
            </v-layout>
          </v-stepper-step>
          <v-stepper-content step="2">
            <checkout-address-card
              :fullname="fullname"
              :address="quote.shipping_address"
              :complete="step > 2"
              :step="2"
              v-on:childMessage="getChildMessage"
            ></checkout-address-card>
          </v-stepper-content>

          <v-stepper-step
            :complete="step > 3"
            step="3"
            class="step-header-container"
          >Payment Options</v-stepper-step>
          <v-stepper-content step="3">
            <checkout-payment-card
              :complete="step > 3"
              :step="3"
              v-on:childMessage="getChildMessage"
            ></checkout-payment-card>
          </v-stepper-content>
        </v-stepper>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      fullname: "",
      valid: false,
      step: 1,
      nameRules: [
        (v) => !!v || "Name is required",
        (v) => (v && v.length <= 10) || "Name must be less than 10 characters",
      ],
      email: "",
      emailRules: [
        (v) => !!v || "E-mail is required",
        (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
      ],
      address: "",
    };
  },

  computed: {
    ...mapGetters(["customer", "quote", "quoteIsEmpty"]),
  },

  methods: {
    getChildMessage(step) {
      if (step == 1) {
        this.fullname = this.customer.name;
      }
      this.step = step + 1;
    },
  },
};
</script>

<style lang="scss">
.v-stepper__label {
  width: 100%;
  .step-header {
    width: 100%;
  }
}
.step-header-container {
  padding: 12px 4px 0 4px !important;
}
.v-stepper__content {
  padding: 0 !important;
  margin: 0 !important;
}
</style>
