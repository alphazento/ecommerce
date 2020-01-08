<template>
  <PayPal
    :env="configs.mode"
    :amount="amount"
    :currency="cart.currency"
    :client="configs.credentials"
    :button-style="configs.style"
    v-on:payment-authorized="authorized"
    v-on:payment-completed="completed"
    v-on:payment-cancelled="cancelled"
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
    },
    authorized(response) {},
    completed(response) {
      this.$store.dispatch("showSpinner", "Placing order...");
      const cartData = this.reducedCartData();
      axios
        .post("/api/v1/payment/capture/paypalexpress", {
          version: "v2",
          quote: cartData,
          payment: response
        })
        .then(response => {
          axios
            .post("/api/v1/sales/orders", {
              pay_id: response.data.data.payment_transaction.pay_id
            })
            .then(response => {
              console.log("order completed", response);
              this.$store.dispatch("showSpinner", "Order placed");
            });
        });
    },
    cancelled(response) {
      console.log("paypal cancelled", response);
    },
    reducedCartData() {
      const cart = this.cart;
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
    cart() {
      return this.$store.state.cart;
    },
    amount() {
      return "" + this.$store.state.cart.grand_total;
    }
  },
  components: {
    PayPal
  }
};
</script>