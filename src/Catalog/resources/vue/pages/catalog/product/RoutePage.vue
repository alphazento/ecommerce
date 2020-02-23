<template>
  <v-tabs v-model="tab">
    <v-tab>All Products</v-tab>
    <v-tab v-if="editItem.model.id">
      <v-icon left>mdi-lock</v-icon>
      {{editItem.model.name}}
      <v-btn icon color="error">
        <v-icon left>mdi-close</v-icon>
      </v-btn>
    </v-tab>

    <v-tab-item>
      <config-data-table
        :search="search"
        name="product"
        data-api-url="catalog/search"
        filter-connect-route
        use-filter
        server-side-pagination
        @proxyAction="proxyAction"
      ></config-data-table>
    </v-tab-item>
    <v-tab-item>
      <z-dyna-attr-model-editor
        :title="'product'"
        :model-name="'catalog/product'"
        :edit-with="editItem"
        @propertyChange="propertyChange"
        @saveModel="saveModel"
      ></z-dyna-attr-model-editor>
    </v-tab-item>
  </v-tabs>
</template>

<script>
import { type } from "os";
export default {
  data() {
    return {
      search: "",
      editItem: {
        isNew: false,
        model: {}
      },
      tab: 0
    };
  },
  methods: {
    proxyAction(event) {
      switch (event.action) {
        case "editProduct":
          this.editItem = { isNew: false, model: event.data };
          this.tab = 1;
          break;
        case "deleteProduct":
          break;
      }
    },
    propertyChange(event) {
      this.$store.dispatch("showSpinner", "Saving Changes...");
      axios
        .patch(
          `/api/v1/admin/catalog/products/${event.model.id}/${event.preoperty}`,
          {
            value: event.value
          }
        )
        .then(response => {
          if (response.data.success) {
            this.$store.dispatch("snackMessage", "Updated.");
          } else {
            this.$store.dispatch("snackMessage", "Failed to update.");
          }
        });
    },
    saveModel(model) {
      this.$store.dispatch("showSpinner", "Saving Changes...");
      axios
        .post("/api/v1/admin/catalog/products", this.model)
        .then(response => {
          this.$store.dispatch("hideSpinner");
        });
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