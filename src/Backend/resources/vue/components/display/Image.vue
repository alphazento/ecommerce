<template>
  <v-img :src="value" :max-width="maxWidth"></v-img>
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
