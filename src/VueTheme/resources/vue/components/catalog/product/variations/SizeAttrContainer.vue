<template>
  <v-chip-group v-model="selection" column>
    <v-chip v-for="(size, i) in items" :key="i" :color="'pink'" outlined>
      <v-avatar left v-if="i === selection">
        <v-icon>mdi-checkbox-marked-circle</v-icon>
      </v-avatar>
      {{ size }}
    </v-chip>
    <input type="hidden" name="options[size]" v-model="items[selection]" />
  </v-chip-group>
</template>

<script>
export default {
  props: {
    items: {
      type: Array,
    },
    current: {
      type: String,
    },
    type: {
      type: String,
    },
  },
  created() {
    let index = this.items.indexOf(this.current);
    this.selection = index < 0 ? undefined : index;
  },
  data() {
    return {
      selection: undefined,
      attr: "size",
    };
  },
  watch: {
    selection(val, old) {
      if (val != old) {
        var value = undefined;
        if (val !== undefined && val > -1) {
          value = this.items[val];
        }
        this.$emit("containerSelected", {
          attr: this.type,
          value: value,
        });
      }
    },
  },
};
</script>
