<template>
  <div>
    <v-data-table
      fixed-header
      :headers="defines"
      :items="pagination.data"
      :search="search"
      :server-items-length="pagination.total"
      :page="pagination.current_page"
      :items-per-page="pagination.per_page"
      :hide-default-footer="serverSidePagination"
      :loading="loading"
      loading-text="Loading... Please wait"
    >
      <template v-slot:body="{ headers, items }">
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
          <tr class="text-start" v-for="(row, ri) of items" :key="ri">
            <td v-for="(header) of headers" :key="header.value">
              <component
                :is="header.ui"
                v-bind="prepare_component_props(header, row)"
                :value="row[header.value]"
              ></component>
            </td>
          </tr>
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
    dataApiUrl: String,
    useFilter: Boolean,
    serverSidePagination: Boolean,
    filterConnectRoute: Boolean
  },
  data() {
    return {
      defines: [],
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
      routeQuery: {}
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
      this.$store.dispatch("showSpinner", "Fetching Defines...");
      this.loading = true;
      axios
        .get(`/api/v1/admin/configs/groups/tables/${this.name}`)
        .then(response => {
          this.realFetchOrders();
          // this.$store.dispatch("hideSpinner");
          if (response.data && response.data.success) {
            this.defines = response.data.data.table.items;
            this.defines.forEach(item => {
              if (item.filterable !== undefined && item.filterable) {
                this.filters[item.value] = "";
              }
            });
          }
        });
    },

    realFetchOrders() {
      this.loading = true;
      var queryString = this.buildQuery(true);
      this.$store.dispatch("showSpinner", "Loading data...");
      axios
        .get(`/api/v1/admin/${this.dataApiUrl}?${queryString}`)
        .then(response => {
          this.$store.dispatch("hideSpinner");
          if (response.data && response.data.success) {
            this.pagination = response.data.data;
          }
          this.loading = false;
        });
    },

    fetchOrders() {
      if (this.filterConnectRoute) {
        this.routeQuery = this.buildQuery(false);
        this.$router.push({ query: this.routeQuery }).catch(err => {
          console.log(err);
        });
      } else {
        this.realFetchOrders();
      }
    },

    buildQuery(returnString) {
      var queryItems = [];
      var routeQuery = {}; //when filterConnectRoute
      for(const[key, value] of Object.entries(this.filters)) {
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
      };
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
      if (item.accessor !== 'page') {
        this.filters['page'] = 1;
      }
      this.fetchOrders();
    },

    paginationHandler(page) {
      if (this.serverSidePagination) {
        this.filters.page = page;
        this.fetchOrders();
      }
    },

    convertRouteQuery() {
      this.routeQuery = Object.assign({}, this.$route.query);
      var filters = {};
      for (const [key, value] of Object.entries(this.routeQuery)) {
        key = key.replace('[]', '');
        if (key === 'page' || key === 'per_page') {
          filters[key] = parseInt(value);
        } else {
          filters[key] = value;
        }
      }
      this.filters = filters;
    },

    convertFilterValue(value, header) {
      if (header.filter_data_type === 'number') {
        if (value !== '') {
          return parseInt(value);
        }
      }
      return value;
    }
  },
  watch: {
    $route() {
      this.realFetchOrders();
      // this.convertRouteQuery();
    }
  }
};
</script>
