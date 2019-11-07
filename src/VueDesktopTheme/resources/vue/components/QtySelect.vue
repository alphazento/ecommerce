<template>
  <v-select class="limit-width" :items="qtys" label="Quantity" outlined required v-model="_value" v-on:change="handleUpdate()"></v-select>
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
      _value: 1
    }
  },
  created() {
    var min = this.min || this._min;
    this._value = this.value || this.min;
    var max = this.max > this._value ? this.max : this._value;
    for(var i=1; i<= max; i++) {
      this.qtys.push(i);
    }
  },
  methods: {
    handleUpdate(){
      this.$emit('input', this._value)
    }
  }
}
</script>

<style scoped>
.limit-width{
  max-width: 100px;
}
</style>