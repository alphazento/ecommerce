<template>
  <div>
    <v-data-table
      fixed-header
      single-sort
      :headers="defines.headers"
      :items="pagination.data"
      :show-select="showSelect"
      :search="search"
      :server-items-length="pagination.total"
      :page="pagination.current_page"
      :items-per-page="pagination.per_page"
      :hide-default-footer="serverSidePagination"
      :loading="loading"
      @update:sort-by="updateSortBy"
      @update:sort-desc="updateSortDesc"
      @item-selected="itemSelected"
      @toggle-select-all="toggleSelectAll"
    >
      <template v-slot:body="{ headers, items, isSelected, select }">
        <tbody>
          <tr v-if="useFilter">
            <td v-for="header of headers" :key="header.value">
              <component
                v-if="!!header.filter_ui"
                :is="header.filter_ui"
                v-bind="prepare_component_props(header)"
                :value="convertFilterValue(filters[header.value], header)"
                @valueChanged="filterChanged"
              ></component>
            </td>
          </tr>
          <template v-for="(row, ri) of items">
            <tr class="text-start" :key="ri">
              <td v-for="(header, hi) of headers" :key="header.value">
                <v-simple-checkbox
                  v-if="showSelect && hi===0"
                  color="green"
                  :value="isSelected(row)"
                  @input="select(row, !isSelected(row))"
                ></v-simple-checkbox>
                <component
                  :is="header.ui"
                  v-bind="prepare_component_props(header, row)"
                  :value="row[header.value]"
                  v-on:proxyEvent="proxyEvent"
                ></component>
              </td>
            </tr>
            <tr v-if="!!row.relative" class="text-start" :key="`${ri}_ext`">
              <td v-for="(header) of headers" :key="header.value">
                <component
                  :is="header.ui"
                  v-bind="prepare_component_props(header, row)"
                  :value="row[header.value]"
                ></component>
              </td>
            </tr>
          </template>
        </tbody>
      </template>
    </v-data-table>

    <div class="text-center pt-2" v-if="serverSidePagination">
      <v-pagination
        circle
        :length="pagination.last_page"
        v-model="filters.page"
        :total-visible="7"
        @input="paginationHandler"
      ></v-pagination>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    search: String,
    name: String,
    showSelect: false,
    dataApiUrl: String,
    useFilter: Boolean,
    serverSidePagination: Boolean,
    filterConnectRoute: Boolean
  },
  data() {
    return {
      defines: {
        headers: [],
        primary_key: "id"
      },
      pagination: {
        data: []
      },
      filters: this.serverSidePagination
        ? {
            page: 1,
            per_page: 15
          }
        : {},
      loading: false,
      routeQuery: {},
      selectedItems: []
    };
  },
  created() {
    if (this.filterConnectRoute) {
      this.convertRouteQuery();
    }
    this.fetchDefines();
  },
  methods: {
    fetchDefines() {
      this.$store.dispatch("SHOW_SPINNER", "Fetching Defines...");
      this.loading = true;
      axios
        .get(`/api/v1/admin/configs/groups/tables/${this.name}`)
        .then(response => {
          this.realfetchData();
          // this.$store.dispatch("HIDE_SPINNER");
          if (response && response.success) {
            this.defines = Object.assign(
              this.defines,
              response.data.table.items
            );

            this.defines.headers.forEach(item => {
              if (item.filterable !== undefined && item.filterable) {
                this.filters[item.value] = "";
              }
            });
          }
        });
    },

    realfetchData() {
      this.loading = true;
      var queryString = this.buildQuery(true);
      this.$store.dispatch("SHOW_SPINNER", "Loading data...");
      axios
        .get(`/api/v1/admin/${this.dataApiUrl}?${queryString}`)
        .then(response => {
          this.$store.dispatch("HIDE_SPINNER");
          if (response) {
            if(response.success) {
              this.pagination = response.data;
              this.selectedItems = [];
            } else {
              if (response.code == 404) {
                this.pagination = {data:[]};
              }
            }
          } 
          this.loading = false;
        });
    },

    fetchData() {
      if (this.filterConnectRoute) {
        this.routeQuery = this.buildQuery(false);
        this.$router.push({ query: this.routeQuery }).catch(err => {
          console.log(err);
        });
      } else {
        this.realfetchData();
      }
    },

    buildQuery(returnString) {
      var queryItems = [];
      var routeQuery = {}; //when filterConnectRoute
      for (const [key, value] of Object.entries(this.filters)) {
        if (value !== undefined && value !== "" && value !== null) {
          if (Array.isArray(value)) {
            var subKey = `${key}[]`;
            value.forEach(v => {
              queryItems.push(`${subKey}=${v}`);
            });
            routeQuery[key] = value;
          } else {
            queryItems.push(`${key}=${value}`);
            routeQuery[key] = value;
          }
        }
      }
      return returnString ? queryItems.join("&") : routeQuery;
    },

    prepare_component_props(header, extraData) {
      var data = Object.assign({}, header);
      data.accessor = data.value;
      delete data.value;
      if (extraData !== undefined) {
        data.extraData = extraData;
      }
      return data;
    },

    filterChanged(item) {
      this.filters[item.accessor] = item.value;
      if (item.accessor !== "page") {
        this.filters["page"] = 1;
      }
      this.fetchData();
    },

    paginationHandler(page) {
      if (this.serverSidePagination) {
        this.filters.page = page;
        this.fetchData();
      }
    },

    convertRouteQuery() {
      this.routeQuery = Object.assign({}, this.$route.query);
      var filters = {};
      for (const [key, value] of Object.entries(this.routeQuery)) {
        key = key.replace("[]", "");
        if (key === "page" || key === "per_page") {
          filters[key] = parseInt(value);
        } else {
          filters[key] = value;
        }
      }
      this.filters = filters;
    },

    convertFilterValue(value, header) {
      if (header.filter_data_type === "number") {
        if (value !== "") {
          return parseInt(value);
        }
      }
      return value;
    },

    updateSortBy(sorts) {
      console.log("multi-sort", sorts);
    },
    updateSortDesc(sorts) {
      console.log("desc-sort", sorts);
    },

    itemSelected(detail) {
      let primary_key = detail.item[this.defines.primary_key];
      if (detail.value) {
        this.selectedItems.push(primary_key);
      } else {
        let idx = this.selectedItems.indexOf(primary_key);
        if (idx >= 0) {
          this.selectedItems.splice(idx, 1);
        }
      }
      if (this.selectedItems.length === 0) {
        return this.$emit("selectedRowsChange", []);
      }
      let items = this.pagination.data.filter(item => {
        return this.selectedItems.includes(item[this.defines.primary_key]);
      });
      this.$emit("selectedRowsChange", items);
    },

    toggleSelectAll(detail) {
      if (detail.value) {
        this.selectedItems = detail.items.map(item => {
          return item[this.defines.primary_key];
        });
        this.$emit("selectedRowsChange", detail.items);
      } else {
        this.selectedItems = [];
        this.$emit("selectedRowsChange", []);
      }
    },
    proxyEvent(event) {
      this.$emit('proxyAction', event);
    }
  },
  watch: {
    $route() {
      this.realfetchData();
      // this.convertRouteQuery();
    }
  }
};
</script>
