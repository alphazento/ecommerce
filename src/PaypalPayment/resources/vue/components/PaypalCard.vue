<template>
  <PayPal
    :env="configs.mode"
    :amount="cart.grand_total"
    :currency="cart.currency"
    :client="configs.credentials"
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
    return {};
  },
  methods: {
    childMessage() {
      this.$emit("childMessage", this.step);
    }
  },
  computed: {
    cart() {
      return this.$store.state.cart;
    }
  },
  components: {
    PayPal
  },
};
</script>