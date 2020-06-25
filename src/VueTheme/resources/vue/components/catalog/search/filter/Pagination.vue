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
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      page: 1,
    };
  },
  created() {
    this.page = this.searchResult.current_page;
  },
  computed: {
    ...mapGetters(["searchResult"]),
  },
  methods: {
    paginateTo(page) {
      this.$store.dispatch("CATALOG_SEARCH_PAGINATE_TO", page);
    },
  },
};
</script>
