<template>
  <v-container>
    <v-card-title>
      <span>Sales Orders</span>
      <v-spacer></v-spacer>
      <!-- <v-text-field
        v-model="search"
        append-icon="mdi-search"
        placeholder="Search in page"
        single-line
        hide-details
      ></v-text-field>-->
      <v-btn :disabled="selectRows.length === 0" color="success">Print Invoice & Pack Slip</v-btn>
    </v-card-title>
    <config-data-table
      schema-key="orders"
      data-api-url="sales/orders"
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
    initBreadCrumbs() {
      this.$store.dispatch("CLEAR_BREADCRUMBS", null);
      this.$store.dispatch("ADD_BREADCRUMB_ITEM", {
        text: "Sales/Orders",
        href: this.$route.path
      });
    },
    selectedRowsChange(rows) {
      this.selectRows = rows;
    }
  },
  created() {
    this.initBreadCrumbs();
  },
  watch: {
    $route() {}
  }
};
</script>
