<template>
  <v-container>
    <v-layout class="row">
      <v-flex md5>
        <v-select
          class="limit-width"
          :items="sorts"
          label="Sort By:"
          required
          v-model="sort_by"
          @input="changeSortBy"
        ></v-select>
      </v-flex>
      <v-flex md2>
        <v-select
          class="limit-width"
          :items="pages"
          label="Show"
          required
          v-model="per_page"
          @input="changePerPage"
        ></v-select>
      </v-flex>
      <v-flex md5 text-right class="v-middle">
        items {{ searchResult.from }}-{{ searchResult.to }} of
        {{ searchResult.total }}
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      per_page: 15,
      pages: [15, 30, 60],
      sort_by: "position,asc",
      sorts: [
        { value: "position,asc", text: "Default" },
        { value: "price,asc", text: "Price-Lowest First" },
        { value: "price,desc", text: "Price-Highest First" },
        { value: "name,asc", text: "Product Name A-Z" },
        { value: "name,desc", text: "Product Name Z-A" },
      ],
    };
  },
  created() {
    this.per_page = this.paginationFilter.per_page;
    this.sort_by = this.paginationFilter.sort_by;
  },
  computed: {
    ...mapGetters(["searchResult", "paginationFilter"]),
  },
  methods: {
    changeSortBy(sort) {
      this.$store.dispatch("CATALOG_SEARCH_SORT_BY", sort);
    },
    changePerPage(per_page) {
      this.$store.dispatch("CATALOG_SEARCH_PAGINATE_PER_PAGE", per_page);
    },
  },
  watch: {
    paginationFilter: function(nV, oV) {
      this.per_page = nV.per_page;
      this.sort_by = nV.sort_by;
      console.log(
        "paginationFilter change",
        this.sort_by,
        this.paginationFilter
      );
    },
  },
};
</script>
