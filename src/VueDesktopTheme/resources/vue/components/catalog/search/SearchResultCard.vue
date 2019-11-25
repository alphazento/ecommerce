<template>
  <v-container>
    <v-layout class="row">
      <v-flex md12 xs8>
        <v-container>
          <h1>Category Name Here</h1>
        </v-container>
      </v-flex>
      <v-flex md4 xs4 class="d-md-none" text-right>
        <v-menu v-model="filter" :close-on-content-click="false" :nudge-width="300" offset-x>
          <template v-slot:activator="{ on }">
            <v-btn color="indigo" text-right dark v-on="on">
              <v-icon>mdi-filter</v-icon>Filter & Sort
            </v-btn>
          </template>
          <v-system-bar dark color="red lighten-2" height="35">
            <v-spacer></v-spacer>
            <v-btn text @click="filter = false">
              <v-icon>mdi-close</v-icon>
            </v-btn>
          </v-system-bar>
          <slot></slot>
        </v-menu>
      </v-flex>
    </v-layout>

    <v-layout class="row">
      <v-flex md4 xs12 class="d-none d-md-block">
        <v-container>
          <slot></slot>
        </v-container>
      </v-flex>
      <v-flex md8 xs12>
        <product-grid :pagination="pagination" :flex="'md4 xs6'"></product-grid>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      filter: false,
      search_nav: true
    };
  },
  computed: {
    pagination() {
      return this.$store.state.searchResult;
    }
  }
};
</script>