<template>
    <div v-if="!!value">
        <p>Paid via:{{ value.payment_method }}</p>
        <p>Paid:{{ value.amount_paid }}</p>
        <p v-if="value.amount_refunded > 0">
            Refunded:{{ value.amount_refunded }}
        </p>
        <p v-if="!!value.payment_transaction_id">
            Pay Ref:{{ value.payment_transaction_id }}
        </p>
        <p v-if="!!value.comment">Comment:{{ value.comment }}</p>
    </div>
</template>

<script>
export default {
    props: {
        value: {
            payment_method: String,
            amount_paid: String,
            amount_refunded: String,
            comment: String,
            payment_transaction_id: String
        }
    }
};
</script>
