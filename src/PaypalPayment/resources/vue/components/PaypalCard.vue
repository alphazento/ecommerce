<template>
  <PayPal
    amount="10.00"
    currency="AUD"
    :client="configs.credentials"
    :env="configs.mode"
    :button-style="configs.style"
  ></PayPal>
</template>

<script>
import PayPal from "vue-paypal-checkout";
export default {
  props: {
    configs: {
      type: Object
    }
  },
  data() {
    // return {
    //   credentials: {
    //     sandbox: "",
    //     production: "<production client id>"
    //   },
    //   btstyle: {
    //     label: "checkout",
    //     size: "responsive",
    //     shape: "pill",
    //     color: "gold"
    //   }
    // };
  },
  methods: {
    childMessage() {
      this.$emit("childMessage", this.step);
    }
  },
  components: {
    PayPal
  },
  // computed: {
  //   userInfo() {
  //     return this.$store.state.consts;
  //   }
  // }
};
</script>