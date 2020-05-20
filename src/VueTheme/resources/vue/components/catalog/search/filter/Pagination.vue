<template>
  <v-pagination
    circle
    :length="searchResult.last_page"
    v-model="page"
    :total-visible="7"
    @input="paginateTo"
  ></v-pagination>
</template>

<script>
export default {
  data() {
    return {
      page: this.$store.state.searchResult.current_page
    };
  },

  computed: {
    searchResult() {
      return this.$store.state.searchResult;
    }
  },
  methods: {
    paginateTo(page) {
      this.$store.dispatch("CATALOG_SEARCH_PAGINATE_TO", page);
    }
  }
};
</script>
