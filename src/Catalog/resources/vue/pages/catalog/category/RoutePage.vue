<template>
  <div>
    <v-card-title>
      <span>Category</span>
    </v-card-title>
    <v-layout>
      <v-flex md3>
        <category-treeview @categoryChanged="categoryChanged"></category-treeview>
      </v-flex>
      <v-flex md8>
        <v-card v-if="mode !== ''">
          <v-card-title :class="dirty ? 'error white--text' : 'deep-purple accent-4 white--text'">
            <span v-if="mode==='new'">New Category of [{{parentCategory.name}}]</span>
            <span v-else>Category[{{category.desc.name}}]</span>
            <v-spacer></v-spacer>
            <v-btn color="primary" fab dark large v-if="dirty">
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
          return;
        }
      }
      if (w !== undefined && w) {
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
        // this.mode = result.data.mode;
        // this.category = JSON.parse(JSON.stringify(result.data.item));
        // this.dirty = false;
        // this.bindCategoryValues(this.mergedData);
        // this.mergedData = Object.assign({}, this.mergedData);
      }
    },
    mergeCategoryData(data) {
      this.mode = data.mode;
      if (this.mode === "new") {
        this.category = {};
        this.parentCategory = data.item;
      } else {
        this.category = JSON.parse(JSON.stringify(data.item));
      }
      this.mergedData = JSON.parse(JSON.stringify(this.originConfigs));
      this.bindCategoryValues(this.mergedData);
      this.mergedData = Object.assign({}, this.mergedData);
      this.dirty = false;
    },
    configValueChanged(item) {
      this.dirty = true;
      this.accessObjectByString(this.category, item.accessor, item.value, true);
      this.bindCategoryValues(this.mergedData);
      this.mergedData = Object.assign({}, this.mergedData);
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