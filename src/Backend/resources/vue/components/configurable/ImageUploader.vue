<template>
  <v-layout>
    <v-flex md10 v-if="!!innerValue">
      <v-img :src="innerValue"></v-img>
    </v-flex>
    <v-flex md2>
      <z-file-picker @fileSelected="fileSelected" v-bind="{...$props, ...$attrs}"></z-file-picker>
    </v-flex>
  </v-layout>
</template>

<script>
import BaseConfig from "./Base";
export default {
  extends: BaseConfig,
  methods: {
    fileSelected(item) {
      this.innerValue = item.value;
      this.valueChanged();
    }
  }
};
</script>
