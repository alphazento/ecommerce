<template>
  <mini-cart-item-simple :item="item">
    <template>
      <div>
        <div v-for="(option, i) of reduced" :key=i>
          <span><strong>{{option.name}}:</strong>{{option.value}}</span>
        </div>
    </div>
    </template>
  </mini-cart-item-simple>
</template>

<script>
import MiniSimple from "./MiniSimple"
export default {
  data() {
    return {
      reduced: []
    }
  },
  created() {
    let keys = Object.keys(this.item.options);
    keys.forEach(name => {
      if (name !== "actual_pid") {
        this.reduced.push({name:name, value: this.item.options[name]});
      }
    });
  }
};
</script>