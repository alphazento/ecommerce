<template>
  <v-pagination
    circle
    :length="searchResult.last_page"
    v-model="page"
    :total-visible="7"
    @input="updatePagination"
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
    updatePagination(val) {
      this.$store.dispatch("updatePagination", { page: val });
    }
  }
};
</script>
