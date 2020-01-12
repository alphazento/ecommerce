<template>
  <div v-if="shipments.length > 0">
    <div v-for="item of shipments" :key="item.id">
      <div>{{ item.address.name }}</div>
      <div v-if="item.address.company">{{ item.address.company }}</div>
      <span>{{ item.address.address1 }},</span>
      <span v-if="item.address.address2">{{ item.address.address2 }},</span>
      <span>{{ item.address.city }}</span>
      <span>{{ item.address.state }}&nbsp;</span>
      <span>{{ item.address.country }}&nbsp;</span>
      <span>{{ item.address.postal_code }}</span>
      <div>TEL:{{ item.address.phone }}</div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    extraData: {
      shipments: Array
    }
  },
  data() {
    return {
      shipments: this.extraData.shipments ? this.extraData.shipments : []
    };
  }
};
</script>
