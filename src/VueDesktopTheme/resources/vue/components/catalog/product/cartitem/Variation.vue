<template>
  <div>
      <div v-for="(item, i) of reduced" :key=i>
        <span><strong>{{item.name}}:</strong>{{item.value}}</span>
      </div>
  </div>
</template>

<script>
import FullSimple from "./FullSimple"
export default {
  data() {
    return {
      reduced: []
    }
  },
  created() {
    let keys = Object.keys(this.options);
    keys.forEach(name => {
      if (name !== "actual_pid") {
        this.reduced.push({name:name, value: this.options[name]});
      }
    });
  }
};
</script>