<template>
  <div>
    <div v-if="payments.length > 0">
      <div v-for="item of payments" :key="item.id">
        <div>Via:{{ item.payment_method }}</div>
        <div>Paid:{{item.currency}} &nbsp;{{ item.amount_paid }}</div>
        <div>Ref:{{ item.ext_transaction_id }}</div>
      </div>
      <div v-if="canRefund">
        <v-btn color="error">Refund</v-btn>
      </div>
    </div>
    <div v-else>
      <v-btn color="primary">Pay</v-btn>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    extraData: {
      payments: Array,
      status_id: Number
    }
  },
  data() {
    return {
      payments: this.extraData.payments ? this.extraData.payments : []
    };
  },
  computed: {
    canRefund() {
      if (this.payments.length === 0) {
        return false;
      }

      // if (this.status_id )  // if it's finalized, can not refund

      var total = 0;
      this.payments.forEach(payment => {
        if (payment.is_refund) {
          total -= payment.amount_paid;
        } else {
          total += payment.amount_paid;
        }
      });
      return total > 0;
    }
  }
};
</script>

