<template>
  <v-img  :max-width="maxWidth"  :src="value" eager></v-img>
</template>

<script>
export default {
  props: {
    value: {
      type: String | Number
    },
    maxWidth: String
  }
};
</script>
