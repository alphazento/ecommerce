<template>
  <v-container>
    <v-layout class="row">
      <v-flex md5>
        <v-select class="limit-width" :items="sorts" label="Sort By:" required v-model="sort_by"></v-select>
      </v-flex>
      <v-flex md2>
        <v-select class="limit-width" :items="pages" label="Show" required v-model="per_page"></v-select>
      </v-flex>
      <v-flex md5 text-right class="v-middle">
        items {{ pagination.from }}-{{ pagination.to }} of
        {{ pagination.total }}
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      per_page: this.$store.state.searchResult.per_page,
      pages: [15, 30, 60],
      sort_by: "position,asc",
      sorts: [
        { value: "position,asc", text: "Default" },
        { value: "price,asc", text: "Price-Lowest First" },
        { value: "price,desc", text: "Price-Highest First" },
        { value: "name,asc", text: "Product Name A-Z" },
        { value: "name,desc", text: "Product Name Z-A" }
      ]
    };
  },
  computed: {
    pagination() {
      return this.$store.state.searchResult;
    }
  },
  watch: {
    per_page: function(val, oldVal) {
      this.$store.dispatch("CATALOG_SEARCH_PAGINATE_PER_PAGE", val);
    },
    sort_by: function(val, oldVal) {
      this.$store.dispatch("CATALOG_SEARCH_SORT_BY", val);
    }
  }
};
</script>

