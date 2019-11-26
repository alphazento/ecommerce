<template>
    <v-card>
        <v-expansion-panels accordion multiple>
            <v-expansion-panel
                v-for="(item, key) in pagination.aggregate"
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
export default {
    props: {},
    data() {
      return {
        routeQuery: {}
      };
    },
    created() {
      this.routeQuery = Object.assign({}, this.$route.query);
    },
    computed: {
        pagination() {
            return this.$store.state.searchResult;
        }
    },
    methods: {
      filterBullet(name) {
          switch (name) {
            case "price":
                return "price-filter-bullet";
            case "category":
                return "category-filter-bullet";
                break;
            default:
                return "dynamic-attribute-filter-bullet";
                break;
          }
      },
      filterChange(e) {
        this.routeQuery[e.filter] = e.data;
        this.$router.push({ query: this.routeQuery });
      }
    },
    watch: {
      $route() {
          this.routeQuery = Object.assign({}, this.$route.query);
          let url =
              "/api/v1/catalog/search" +
              this.$route.fullPath.substr(this.$route.path.length);
          this.$store.dispatch("showSpinner", "Updating...");
          axios.get(url).then(response => {
              this.$store.dispatch("assignSearchResult", response.data.data);
              this.$store.dispatch("hideSpinner");
          });
      }
    }
};
</script>
