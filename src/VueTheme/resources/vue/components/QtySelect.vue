<template>
  <v-select
    class="limit-width"
    :items="qtys"
    label="Quantity"
    required
    v-model="innerValue"
    v-on:change="handleUpdate()"
  ></v-select>
</template>

<script>
export default {
  props: {
    min: {
      type: Number
    },
    max: {
      type: Number
    },
    value: {
      type: Number
    }
  },
  data() {
    return {
      qtys: [],
      innerValue: 1
    };
  },
  created() {
    var min = this.min || this._min;
    this.innerValue = this.value || this.min;
    var max = this.max > this.innerValue ? this.max : this.innerValue;
    for (var i = 1; i <= max; i++) {
      this.qtys.push(i);
    }
  },
  methods: {
    handleUpdate() {
      this.$emit("input", this.innerValue);
      this.$emit("change", this.innerValue);
    }
  }
};
</script>

<style scoped>
.limit-width {
  max-width: 100px;
}
</style>