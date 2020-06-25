<template>
  <v-card>
    <v-expansion-panels accordion multiple>
      <v-expansion-panel
        v-for="(item, key) in searchResult.aggregate"
        :key="key"
      >
        <v-expansion-panel-header text-left>
          <span>{{ item.label }}</span>
        </v-expansion-panel-header>
        <v-expansion-panel-content>
          <component
            :is="filterBullet(key)"
            v-bind="item"
            @filterChange="filterChange"
          ></component>
        </v-expansion-panel-content>
      </v-expansion-panel>
    </v-expansion-panels>
  </v-card>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  props: {
    pageData: Object,
  },
  data() {
    return {
      routeQuery: {},
    };
  },
  created() {
    this.routeQuery = Object.assign({}, this.$route.query);
  },
  computed: {
    ...mapGetters(["searchResult", "paginationFilter"]),
  },
  methods: {
    filterBullet(name) {
      switch (name) {
        case "price":
          return "price-filter-bullet";
        case "category":
          return "category-filter-bullet";
        default:
          return "dynamic-attribute-filter-bullet";
      }
    },
    filterChange(e) {
      this.routeQuery[e.filter] = e.data;
      this.$router.push({ query: this.routeQuery }).catch((err) => {});
    },
    diffKeyInPagination(val1, val2) {
      var keys = Object.keys(val1);
      for (var key of keys) {
        if (val1[key] !== val2[key]) {
          return key;
        }
      }
    },
  },
  watch: {
    $route() {
      this.routeQuery = Object.assign({}, this.$route.query);
      let url =
        this.pageData.uri +
        this.$route.fullPath.substr(this.$route.path.length);
      this.$store.dispatch("CATALOG_SEARCH_REQUEST", url);
    },
    paginationFilter(val, oldVal) {
      var filterName = this.diffKeyInPagination(val, oldVal);
      if (filterName) {
        this.filterChange({ filter: filterName, data: val[filterName] });
      }
    },
  },
};
</script>
