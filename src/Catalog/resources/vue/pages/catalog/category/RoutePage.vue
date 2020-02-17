<template>
  <div>
    <v-card-title>
      <span>Category</span>
    </v-card-title>
    <v-layout>
      <v-flex md3>
        <category-treeview :selected-item="seletedTreeviewItem" @categoryChange="categoryChange"></category-treeview>
      </v-flex>
      <v-flex md8>
        <v-card v-if="mode !== ''">
          <v-card-title :class="dirty ? 'error white--text' : 'deep-purple accent-4 white--text'">
            <span v-if="mode==='new'">New Category of [{{parentCategory.name}}]</span>
            <span v-else>{{category.name}}</span>
            <v-spacer></v-spacer>
            <v-btn color="primary" fab dark large v-if="dirty" @click="saveCategory">
              <v-icon dark>mdi-content-save</v-icon>
            </v-btn>
          </v-card-title>

          <config-model-editor
            model="catalog/category"
            :model-data="modelData"
            :with-value="false"
            @fetchSchema="fetchSchema"
            @configValueChanged="configValueChanged"
          ></config-model-editor>
        </v-card>
        <v-container v-else>
          <span color="error">Please select Category first</span>
        </v-container>
      </v-flex>
    </v-layout>
  </div>
</template>

<script>
import { type } from 'os';
export default {
  data() {
    return {
      mode: "",
      dirty: false,
      category: {},
      seletedTreeviewItem: {
        mode: "",
        id: -1
      },
      schema: {},
      schemaFetched: false,
      modelData: {},
      parentCategory: {}
    };
  },
  methods: {
    accessObjectByString(o, s, nV, w) {
      s = s.replace(/\[(\w+)\]/g, ".$1"); // convert indexes to properties
      s = s.replace(/^\./, ""); // strip a leading dot
      var a = s.split(".");
      var pK = "",
        pV = null; //previous key and value
      for (var i = 0, n = a.length; i < n; ++i) {
        var k = a[i];
        if (k in o) {
          pK = k;
          pV = o;
          o = o[k];
        } else {
          if (w) {
            o[k] = nV;
          }
          return;
        }
      }
      if (w) {
        pV[pK] = nV;
      }
      return o;
    },

    fetchSchema(schema) {
      this.schema = schema;
      this.schemaFetched = true;
      this.combineModel();
    },
    
    bindValues(o, from) {
      for (const [key, item] of Object.entries(o)) {
        if (item && (typeof item === "object")) {
          if (item["accessor"] !== undefined) {
            item["value"] = this.accessObjectByString(
              from,
              item["accessor"]
            );
          } else {
            this.bindValues(item, from);
          }
        }
      }
    },

    categoryChange(event) {
      if (event.mode === "new" || this.category.id !== event.item.id) {
        if (this.dirty && this.mode !== "") {
          eventBus.$emit("openDialog", {
            component: "z-dialog-confirm-body",
            bind: {
              title:
                "<p>Unsaved Changes</p>If you proceed to edit new category, any changes you have made will be lost. Are you sure you want to edit new category?",
              passData: data
            },
            closeNotify: this.handleConfirm
          });
        } else {
          this.mergeCategoryData(event);
        }
      }
    },

    handleConfirm(result) {
      if (result.success) {
        this.mergeCategoryData(result.data);
      }
    },

    mergeCategoryData(data) {
      this.mode = data.mode;
      if (this.mode === "new") {
        this.category = {
          parent_id: data.item.id,
          level: data.item.level + 1,
          path: data.item.path
        };
        this.parentCategory = data.item;
      } else {
        this.category = JSON.parse(JSON.stringify(data.item));
      }

      if (this.schemaFetched) {
        this.combineModel();
      }
      
      this.dirty = false;
      this.seletedTreeviewItem.mode = data.mode;
      this.seletedTreeviewItem.id = data.item.id;
    },

    combineModel() {
        let modelData = JSON.parse(JSON.stringify(this.schema));
        this.bindValues(modelData, this.category);
        this.modelData = Object.assign({}, modelData);
    },

    configValueChanged(item) {
      this.accessObjectByString(this.category, item.accessor, item.value, true);
      this.bindValues(this.modelData, this.category);
      this.modelData = Object.assign({}, this.modelData);
      if (this.seletedTreeviewItem.mode === "new") {
        this.dirty = true;
      } else {
        this.$store.dispatch("showSpinner", "Saving Changes...");
        axios
          .patch(
            `/api/v1/admin/catalog/categories/${this.category.id}/${item.accessor}`,
            {
              value: item.value
            }
          )
          .then(response => {
            if (response.data.success) {
              this.$store.dispatch("snackMessage", "Updated.");
            } else {
              this.$store.dispatch("snackMessage", "Failed to update.");
            }
          });
      }
      console.log("category1", this.category);
    },

    saveCategory() {
      this.$store.dispatch("showSpinner", "Saving Changes...");
      axios
        .post("/api/v1/admin/catalog/categories", this.category)
        .then(response => {
          this.$store.dispatch("hideSpinner");
          console.log(response);
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