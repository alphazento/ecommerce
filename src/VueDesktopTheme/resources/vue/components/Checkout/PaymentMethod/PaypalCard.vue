<template>
  <v-layout>
    <v-flex>
      <PayPal
        amount="10.00"
        currency="AUD"
        :client="credentials"
        env="sandbox"
        :button-style="btstyle"
      ></PayPal>
    </v-flex>
  </v-layout>
</template>

<script>
import PayPal from "vue-paypal-checkout";
export default {
  props: {},
  data() {
    return {
      credentials: {
        sandbox: "",
        production: "<production client id>"
      },
      btstyle: {
        label: "checkout",
        size: "responsive",
        shape: "pill",
        color: "gold"
      }
    };
  },
  methods: {
    childMessage() {
      this.$emit("childMessage", this.step);
    }
  },
  components: {
    PayPal
  }
};
</script>