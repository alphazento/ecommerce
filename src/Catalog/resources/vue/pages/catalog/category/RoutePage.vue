<template>
  <div>
    <v-card-title>
      <span>Category</span>
    </v-card-title>
    <v-layout>
      <v-flex md3>
        <category-treeview :selected-item="seletedTreeviewItem" @categoryChanged="categoryChanged"></category-treeview>
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
            :model-data="mergedData"
            :with-value="false"
            @modelConfigDataFetched="modelConfigDataFetched"
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
      mergedData: {},
      originConfigs: {},
      parentCategory: {}
    };
  },
  methods: {
    modelConfigDataFetched(item) {
      this.originConfigs = item;
      this.mergedData = JSON.parse(JSON.stringify(this.originConfigs));
      this.bindCategoryValues(this.mergedData);
      this.mergedData = Object.assign({}, this.mergedData);
    },
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

    bindCategoryValues(o) {
      for (const [key, item] of Object.entries(o)) {
        if (typeof item === "object") {
          if (item["accessor"] !== undefined) {
            item["value"] = this.accessObjectByString(
              this.category,
              item["accessor"]
            );
          } else {
            this.bindCategoryValues(item);
          }
        }
      }
    },

    categoryChanged(data) {
      if (data.mode === "new" || this.category.id !== data.item.id) {
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
          this.mergeCategoryData(data);
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
      this.mergedData = JSON.parse(JSON.stringify(this.originConfigs));
      this.bindCategoryValues(this.mergedData);
      this.mergedData = Object.assign({}, this.mergedData);
      this.dirty = false;
      this.seletedTreeviewItem.mode = data.mode;
      this.seletedTreeviewItem.id = data.item.id;
    },
    configValueChanged(item) {
      this.accessObjectByString(this.category, item.accessor, item.value, true);
      this.bindCategoryValues(this.mergedData);
      this.mergedData = Object.assign({}, this.mergedData);
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