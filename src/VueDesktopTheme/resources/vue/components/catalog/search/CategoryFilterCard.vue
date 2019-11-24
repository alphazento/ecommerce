<template>
  <v-card>
    <v-expansion-panels accordion multiple>
      <v-expansion-panel v-for="(item,i) in pagination.aggregate" :key="i">
        <v-expansion-panel-header text-left>
          <span>{{item.label}}</span>
        </v-expansion-panel-header>
        <v-expansion-panel-content>
          <price-filter-bullet v-if="i==='price'" :range="item.items"></price-filter-bullet>
          <switchitem-filter-bullet :items="item.items" v-if="i!=='price'"></switchitem-filter-bullet>
        </v-expansion-panel-content>
      </v-expansion-panel>
    </v-expansion-panels>
  </v-card>
</template>

<script>
export default {
  props: {},
  data() {
    return {
      fav: true,
      menu: false,
      message: false,
      hints: true
    };
  },
  computed: {
    pagination() {
      return this.$store.state.searchResult;
    }
  }
};
</script>