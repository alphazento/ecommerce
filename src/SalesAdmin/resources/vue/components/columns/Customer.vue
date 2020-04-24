<template>
  <div v-if="!!value">
    <div>{{ value.name }}</div>
    <div>{{ value.email }}</div>
    <div>IP: {{ extraData.remote_ip }}</div>
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
      remote_ip: String
    }
  }
};
</script>
