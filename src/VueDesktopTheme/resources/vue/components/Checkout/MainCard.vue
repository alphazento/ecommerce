<template>
  <v-stepper v-model="e6" vertical>
    <v-stepper-step :complete="e6>1" step="1">
      <v-layout>
        <v-flex md10>Contact Details</v-flex>
        <v-flex md2>(Edit)</v-flex>
      </v-layout>
      <small>Email, Name</small>
    </v-stepper-step>
    <v-stepper-content :step="1">
      <checkout-contact-card :complete="e6>1" :step="1" v-on:childMessage="getChildMessage"></checkout-contact-card>
    </v-stepper-content>

    <v-stepper-step :complete="e6 > 2" step="2">Delivery Address</v-stepper-step>
    <v-stepper-content step="2">
      <checkout-address-card :complete="e6>2" :step="2" v-on:childMessage="getChildMessage"></checkout-address-card>
    </v-stepper-content>

    <v-stepper-step :complete="e6 > 3" step="3">Payment Options</v-stepper-step>
    <v-stepper-content step="3">
      <checkout-payment-card :complete="e6>3" :step="3" v-on:childMessage="getChildMessage"></checkout-payment-card>
    </v-stepper-content>

    <v-stepper-step step="4">View setup instructions</v-stepper-step>
    <v-stepper-content step="4">
      <v-card color="grey lighten-1" class="mb-12" height="200px"></v-card>
      <v-btn color="primary" @click="e6 = 1">Continue</v-btn>
      <v-btn text>Cancel</v-btn>
    </v-stepper-content>
  </v-stepper>
</template>

<script>
export default {
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