<template>
    <div v-if="!!value">
        <p>{{ value.name }}</p>
        <p>Email: {{ value.email }}</p>
        <p>Customer Note: {{ order.customer_note }}</p>
        <p>IP: {{ order.remote_ip }}</p>
    </div>
</template>

<script>
export default {
    props: {
        value: {
            name: String,
            email: String
        },
        order: {
            customer_note: String,
            remote_ip: String
        }
    }
};
</script>
