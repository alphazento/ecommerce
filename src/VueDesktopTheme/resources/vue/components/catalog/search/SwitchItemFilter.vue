<template>
  <v-list>
    <v-list-item v-for="(item, i) in items" :key="i">
      <v-list-item-action>
        <v-switch v-model="item.id" color="purple"></v-switch>
      </v-list-item-action>
      <v-list-item-title>{{item.name}}</v-list-item-title>
    </v-list-item>
  </v-list>
</template>

<script>
export default {
  props: {
    items: {
      type: Array
    }
  },
  computed: {}
};
</script>