<template>
  <div>
    <v-card-title>
      <span>Category</span>
    </v-card-title>
    <v-layout>
      <v-flex md3>
        <category-treeview></category-treeview>
      </v-flex>
      <v-flex md8>
        <catalog-model-editor model="category"></catalog-model-editor>
      </v-flex>
    </v-layout>
  </div>
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

<style scoped>
.v-middle {
  margin-top: auto;
  margin-bottom: auto;
}
.bottom-line {
  border-bottom: 1px solid grey;
}
.component-container {
  padding-top: 18px;
}
</style>