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
            <td v-for="col of headers" :key="col.accessor">
              <component
                v-if="!!col.filter_ui"
                :is="col.filter_ui"
                v-bind="prepare_component_props(col)"
                :value="filters[col.accessor]"
                @valueChanged="filterChanged"
              ></component>
            </td>
          </tr>
          <tr class="text-start" v-for="(row, i) of items" :key="i">
            <td v-for="(col, ci) of headers" :key="ci">
              <component
                :is="col.ui"
                v-bind="prepare_component_props(col, row)"
                :value="row[col.value]"
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
    serverSidePagination: Boolean
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
      loading: false
    };
  },
  created() {
    this.fetchDefines();
    this.fetchOrders();
  },
  methods: {
    fetchDefines() {
      this.$store.dispatch("showSpinner", "Fetching Defines...");
      this.loading = true;
      axios
        .get(`/api/v1/admin/configs/groups/tables/${this.name}`)
        .then(response => {
          this.fetchOrders();
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

    fetchOrders() {
      this.loading = true;
      var queryString = this.buildQuery();
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

    buildQuery() {
      var queryItems = [];
      Object.keys(this.filters).forEach(key => {
        var value = this.filters[key];
        if (value !== undefined && value !== "" && value !== null) {
          if (Array.isArray(value)) {
            var subKey = `${key}[]`;
            value.forEach(v => {
              queryItems.push(`${subKey}=${v}`);
            });
          } else {
            queryItems.push(`${key}=${value}`);
          }
        }
      });
      return queryItems.join("&");
    },

    prepare_component_props(columDefines, extraData) {
      var data = Object.assign({}, columDefines);
      data.accessor = columDefines.value;
      delete data.value;
      if (extraData !== undefined) {
        data.extraData = extraData;
      }
      return data;
    },

    filterChanged(item) {
      this.filters[item.accessor] = item.value;
      this.fetchOrders();
    },

    paginationHandler(page) {
      if (this.serverSidePagination) {
        this.filters.page = page;
        this.fetchOrders();
      }
    }
  }
};
</script>
