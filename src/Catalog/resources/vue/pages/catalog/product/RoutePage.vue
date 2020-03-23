<template>
  <v-tabs v-model="tab">
    <v-menu bottom right>
      <template v-slot:activator="{ on }">
        <v-btn text class="align-self-center mr-4" v-on="on">
          more
          <v-icon right>mdi-menu-down</v-icon>
        </v-btn>
      </template>

      <v-list class="grey lighten-3">
        <v-list-item>
          <v-btn color="error" @click="newProductTab" v-if="!editItem.isNew || !productTab">
            <v-icon>mdi-plus-circle</v-icon>New Product
          </v-btn>
        </v-list-item>
      </v-list>
    </v-menu>

    <v-tab>
      <v-icon left>mdi-lock</v-icon>
      <span>All Products</span>
    </v-tab>
    <v-tab v-if="productTab">
      <v-icon left>mdi-lock</v-icon>
      <span class="error" v-if="editItem.isNew">New Product</span>
      <span v-else>{{editItem.model.name}}</span>
      <v-btn icon color="error" @click="closeProductTab">
        <v-icon>mdi-close</v-icon>
      </v-btn>
    </v-tab>

    <v-tab-item>
      <config-data-table
        :search="search"
        schema-key="product"
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
        @defaultAttributeSet="setDefaultAttributeSet"
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
      tab: 0,
      productTab: false,
      defaultAttributeSet: { id: 0 }
    };
  },
  methods: {
    initBreadCrumbs() {
      this.$store.dispatch("CLEAR_BREADCRUMBS", null);
      this.$store.dispatch("ADD_BREADCRUMB_ITEM", {
        text: "Catalog/Product",
        href: this.$route.path
      });
    },
    proxyAction(event) {
      switch (event.action) {
        case "editProduct":
          this.editItem = { isNew: false, model: event.data };
          this.tab = 1;
          this.productTab = true;
          break;
        case "deleteProduct":
          break;
      }
    },
    propertyChange(event) {
      this.$store.dispatch("SHOW_SPINNER", "Saving Changes...");
      axios
        .patch(
          `/api/v1/admin/catalog/products/${event.model.id}/${event.preoperty}`,
          {
            value: event.value
          }
        )
        .then(response => {
          if (response.success) {
            Object.assign(this.editItem.model, response.data);
            this.$store.dispatch("SNACK_MESSAGE", "Updated.");
          } else {
            this.$store.dispatch("SNACK_MESSAGE", "Failed to update.");
          }
        });
    },
    saveModel(model) {
      this.$store.dispatch("SHOW_SPINNER", "Saving Changes...");
      axios
        .post("/api/v1/admin/catalog/products", this.model)
        .then(response => {
          this.$store.dispatch("HIDE_SPINNER");
        });
    },
    setDefaultAttributeSet(daset) {
      this.defaultAttributeSet = daset;
    },
    closeProductTab() {
      this.productTab = false;
    },
    newProductTab() {
      this.editItem = {
        isNew: true,
        model: {
          name: "",
          visibility: 3,
          attribute_set_id: this.defaultAttributeSet.id,
          model_type: "simple",
          active: "false"
        }
      };
      this.tab = 1;
      this.productTab = true;
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
