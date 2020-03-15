<template>
  <v-card>
    <v-card-title>{{title}}</v-card-title>
    <v-card-text>
      <v-list-item v-for="(item) of models" :key="item">
        <a :class="color(item)" @click.stop="navToModel(item)">{{item}} Model</a>
      </v-list-item>
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  props: {
    title: String,
    model: String
  },
  data() {
    return {
      models: ["Category", "Product", "Customer"],
      current: this.model
    };
  },
  methods: {
    navToModel(model) {
      this.current = model;
      this.$emit("navToModel", model);
    },
    color(item) {
      return this.current == item ? "indigo white--text" : "";
    }
  }
};
</script>
