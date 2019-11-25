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
    },
    query: {
      type: String
    }
  },
  data() {
    return {
      switchs: {},
    }
  },
  created() {
    console.log('tony route', this.$route)
    this.items.forEach(element => console.log(element));
  },
  watch: { 
      items: function(newVal, oldVal) { // watch it
        console.log('switch filter items change', newVal);
      }
    }
};
</script>