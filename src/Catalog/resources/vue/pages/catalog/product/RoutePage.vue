<template>
  <v-container>
    <v-card-title>
      <span>Products</span>
      <v-spacer></v-spacer>
      <v-btn :disabled="selectRows.length === 0" color="success">Print Invoice & Pack Slip</v-btn>
    </v-card-title>
    <config-data-table
      name="products"
      data-api-url="/catalog/search"
      :search="search"
      use-filter
      :show-select="true"
      server-side-pagination
      filter-connect-route
      @selectedRowsChange="selectedRowsChange"
    ></config-data-table>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      search: "",
      selectRows: []
    };
  },
  methods: {
    selectedRowsChange(rows) {
      this.selectRows = rows;
    }
  },
  watch: {
    $route() {}
  }
};
</script>
