<template>
    <div v-if="!!value">
        <p>{{ value.name }}</p>
        <p>Email: {{ value.email }}</p>
        <p>Customer Note: {{ extraData.customer_note }}</p>
        <p>IP: {{ extraData.remote_ip }}</p>
        <p>Ship to</p>
    </div>
</template>

<script>
export default {
    props: {
        value: {
            name: String,
            email: String
        },
        extraData: {
            customer_note: String,
            remote_ip: String
        }
    }
};
</script>
