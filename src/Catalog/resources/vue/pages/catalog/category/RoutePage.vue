<template>
  <div>
    <v-card-title>
      <span>Category</span>
    </v-card-title>
    <v-layout>
      <v-flex md3>
        <category-treeview :refresh="categories_changes" :edit-item="editItem" @selectedItemChange="selectedItemChange"></category-treeview>
      </v-flex>
      <v-flex md8>
        <z-dyna-attr-model-editor v-if="editItem.model.id >= 0"
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
import { type } from 'os';
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
        level:0
      },
      categories_changes:0
    };
  },
  methods: {
    selectedItemChange(event) {
      this.editItem = event;
      if (event.isNew) {
        this.newModel = Object.assign(this.newModel, {
          name: "",
          parent_id: event.model.id,
          level: event.model.level + 1,
        })
      }
    },

    propertyChange(event) {
      this.$store.dispatch("showSpinner", "Saving Changes...");
      axios
        .patch(
          `/api/v1/admin/catalog/categories/${event.model.id}/${event.preoperty}`,
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
        .post("/api/v1/admin/catalog/categories", model)
        .then(response => {
          if (response.data.success) {
            this.editItem = {
              isNew: false,
              model: response.data.data
            }
            this.$store.dispatch('snackMessage', "New Category Created.");
            this.categories_changes ++;
          } else {
            this.$store.dispatch('snackMessage', response.data.message);
          }
          this.$store.dispatch("hideSpinner");
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
