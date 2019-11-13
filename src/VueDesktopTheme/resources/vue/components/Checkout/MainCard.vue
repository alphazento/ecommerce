<template>
  <v-layout class="cart-row">
    <v-flex md4 xs12>
      <checkout-cart-card :cart="cart"></checkout-cart-card>
    </v-flex>

    <v-flex md8 xs12>
      <v-stepper v-model="e6" vertical>
        <v-stepper-step :complete="e6>1" step="1" class="step-header-container">
          <v-layout class="step-header">
            <v-flex md8>Contact Details</v-flex>
            <v-flex v-if="e6 > 1" md4 class="text-right"><a @click="e6=1">Edit</a></v-flex>
          </v-layout>
          <small>Email, Name</small>
        </v-stepper-step>
        <v-stepper-content :step="1">
          <checkout-contact-card :complete="e6>1" :step="1" v-on:childMessage="getChildMessage"></checkout-contact-card>
        </v-stepper-content>

        <v-stepper-step :complete="e6 > 2" step="2">
          <v-layout class="step-header">
            <v-flex md8>Delivery Address</v-flex>
            <v-flex v-if="e6 > 2" md4 class="text-right"><a @click="e6=2">Edit</a></v-flex>
          </v-layout>
        </v-stepper-step>
        <v-stepper-content step="2">
          <checkout-address-card :address="cart.shipping_address" :complete="e6>2" :step="2" v-on:childMessage="getChildMessage"></checkout-address-card>
        </v-stepper-content>

        <v-stepper-step :complete="e6 > 3" step="3">Payment Options</v-stepper-step>
        <v-stepper-content step="3">
          <checkout-payment-card :complete="e6>3" :step="3" v-on:childMessage="getChildMessage"></checkout-payment-card>
        </v-stepper-content>
      </v-stepper>
    </v-flex>
  
  </v-layout>
</template>

<script>
export default {
  props: {
    cart: {
      type: Object
    }
  },
  data() {
    return {
      valid: false,
      e6: 1,
      nameRules: [
        v => !!v || "Name is required",
        v => (v && v.length <= 10) || "Name must be less than 10 characters"
      ],
      email: "",
      emailRules: [
        v => !!v || "E-mail is required",
        v => /.+@.+\..+/.test(v) || "E-mail must be valid"
      ],
      address: ""
    };
  },
  created() {},
  methods: {
    getChildMessage(step) {
      this.e6 = step + 1;
    }
  }
};
</script>

<style lang="scss">
.cart-row {
    display: flex;
    flex-wrap: wrap;
    flex: 1 1 auto;
}

.v-stepper__label {
  width:100%;
  .step-header {
    width:100%;
  }
}
</style>