<template>
  <PayPal
    :env="configs.mode"
    :amount="quote.grand_total"
    :currency="quote.currency"
    :client="configs.credentials"
    :button-style="configs.style"
    v-on:payment-authorized="authorized"
    v-on:payment-completed="completed"
    v-on:payment-cancelled="cancelled"
  ></PayPal>
</template>

<script>
import PayPal from "vue-paypal-checkout";
import { mapGetters } from "vuex";

export default {
  props: {
    configs: {
      type: Object
    }
  },
  methods: {
    childMessage() {
      this.$emit("childMessage", this.step);
    },
    authorized(response) {},
    completed(response) {
      this.$store.dispatch("SHOW_SPINNER", "Placing order...");
      const cartData = this.reducedCartData();
      axios
        .post("/api/v1/payment/capture/paypalexpress", {
          version: "v2",
          quote: cartData,
          payment: response
        })
        .then(response => {
          this.$store
            .dispatch(
              "PLACE_ORDER_REQUEST",
              response.data.payment_transaction.pay_id
            )
            .then(response => {
              window.location.href = "/checkout/success";
            });
        });
    },
    cancelled(response) {
      console.log("paypal cancelled", response);
    },
    reducedCartData() {
      const cart = this.quote;
      const cartItems = [];
      cart.items.forEach(item => {
        let cartItem = {};
        Object.keys(item).forEach(key => {
          if (key !== "product") {
            cartItem[key] = item[key];
          }
        });
        cartItems.push(cartItem);
      });

      const data = {
        items: cartItems
      };
      Object.keys(cart).forEach(key => {
        if (key !== "items") {
          data[key] = cart[key];
        }
      });
      return data;
    }
  },
  computed: {
    ...mapGetters(["quote"])
  },
  components: {
    PayPal
  }
};
</script>
