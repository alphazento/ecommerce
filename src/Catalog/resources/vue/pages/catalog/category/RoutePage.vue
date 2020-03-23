<template>
  <div>
    <v-card-title>
      <span>Category</span>
    </v-card-title>
    <v-layout>
      <v-flex md3>
        <category-treeview
          :refresh="categories_changes"
          :edit-item="editItem"
          @selectedItemChange="selectedItemChange"
        ></category-treeview>
      </v-flex>
      <v-flex md8>
        <z-dyna-attr-model-editor
          v-if="editItem.model.id >= 0"
          :new-model-title="newModelTitle"
          :model-name="'catalog/category'"
          :edit-with="editItem"
          :new-model="newModel"
          @propertyChange="propertyChange"
          @saveModel="saveModel"
        ></z-dyna-attr-model-editor>
      </v-flex>
    </v-layout>
  </div>
</template>

<script>
import { type } from "os";
export default {
  data() {
    return {
      editItem: {
        isNew: false,
        model: {}
      },
      newModel: {
        name: "",
        parent_id: 0,
        level: 0
      },
      categories_changes: 0
    };
  },
  created() {
    this.initBreadCrumbs();
  },
  methods: {
    initBreadCrumbs() {
      this.$store.dispatch("CLEAR_BREADCRUMBS", null);
      this.$store.dispatch("ADD_BREADCRUMB_ITEM", {
        text: "Catalog/Category",
        href: this.$route.path
      });
    },
    selectedItemChange(event) {
      this.editItem = event;
      if (event.isNew) {
        this.newModel = Object.assign(this.newModel, {
          name: "",
          parent_id: event.model.id,
          level: event.model.level + 1
        });
      }
    },

    propertyChange(event) {
      this.$store.dispatch("SHOW_SPINNER", "Saving Changes...");
      axios
        .patch(
          `/api/v1/admin/catalog/categories/${event.model.id}/${event.preoperty}`,
          {
            value: event.value
          }
        )
        .then(response => {
          if (response.success) {
            this.$store.dispatch("SNACK_MESSAGE", "Updated.");
          } else {
            this.$store.dispatch("SNACK_MESSAGE", "Failed to update.");
          }
        });
    },

    saveModel(model) {
      this.$store.dispatch("SHOW_SPINNER", "Saving Changes...");
      axios.post("/api/v1/admin/catalog/categories", model).then(response => {
        if (response.success) {
          this.editItem = {
            isNew: false,
            model: response.data
          };
          this.$store.dispatch("SNACK_MESSAGE", "New Category Created.");
          this.categories_changes++;
        } else {
          this.$store.dispatch("SNACK_MESSAGE", response.message);
        }
        this.$store.dispatch("HIDE_SPINNER");
      });
    }
  },
  computed: {
    newModelTitle() {
      if (this.editItem.isNew) {
        return `New Category of [${this.editItem.model.name}]`;
      } else {
        return "";
      }
    }
  }
};
</script>
