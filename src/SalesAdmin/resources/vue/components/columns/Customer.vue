<template>
  <div v-if="!!value">
    <div>{{ value.name }}</div>
    <div>{{ value.email }}</div>
    <div>Customer Note: {{ extraData.customer_note }}</div>
    <div>IP: {{ extraData.remote_ip }}</div>
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
