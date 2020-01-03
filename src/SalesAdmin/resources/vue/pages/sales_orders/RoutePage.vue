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
    </v-card-title>
    <config-data-table
      name="orders"
      data-api-url="sales/orders"
      :search="search"
      use-filter
      :show-select="true"
      server-side-pagination
      filter-connect-route
    ></config-data-table>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      search: ""
    };
  },
  watch: {
    $route() {}
  }
};
</script>
