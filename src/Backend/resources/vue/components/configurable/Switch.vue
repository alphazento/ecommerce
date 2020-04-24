<template>
  <v-switch v-model="innerValue" @change="valueChanged" color="purple"></v-switch>
</template>

<script>
import BaseConfig from "./Base";
export default {
  methods: {
    getValue() {
      this.innerValue = !!this.innerValue;
      return this.innerValue;
    }
  },
  extends: BaseConfig
};
</script>
