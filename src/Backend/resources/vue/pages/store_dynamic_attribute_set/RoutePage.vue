<template>
  <v-layout>
    <v-flex md2>
      <z-simple-model-navigator
        title="Attribute Sets"
        :models="['Category', 'Product', 'Customer']"
        :model="model"
        @navToModel="navToModel"
      ></z-simple-model-navigator>
    </v-flex>

    <v-flex md10>
      <v-tabs v-model="tab" v-if="!!model">
        <v-menu bottom right>
          <template v-slot:activator="{ on }">
            <v-btn text class="align-self-center mr-4" v-on="on">
              more
              <v-icon right>mdi-menu-down</v-icon>
            </v-btn>
          </template>
          <v-list class="grey lighten-3">
            <v-list-item>
              <v-btn color="error" @click="newAttributeSet" v-if="editMode != 'new' || !editorTab">
                <v-icon>mdi-plus-circle</v-icon>New Attribute
                Set
              </v-btn>
            </v-list-item>
          </v-list>
        </v-menu>

        <v-tab>
          <v-icon left>mdi-lock</v-icon>
          <span>All Attribute Sets of {{ model }}</span>
        </v-tab>
        <v-tab v-if="editorTab">
          <v-icon left>mdi-lock</v-icon>
          <span class="error" v-if="editMode == 'new'">New Attribute Set</span>
          <span v-else>{{ selectedItem.name }}</span>
          <v-btn icon color="error" @click="closeEditorTab">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-tab>

        <v-tab-item>
          <v-card v-if="!!model">
            <v-card-title>
              <v-text-field
                v-model="search"
                append-icon="mdi-search"
                label="Search"
                single-line
                hide-details
              ></v-text-field>
            </v-card-title>
            <v-data-table :headers="defines" :items="data" :search="search">
              <template v-slot:body="{ headers, items }">
                <tbody>
                  <tr class="text-start" v-for="(row, i) of items" :key="i">
                    <td v-for="(col, ci) of headers" :key="ci">
                      <v-btn v-if="ci == 0" icon @click="editAttributeSet(row)" color="primary">
                        <v-icon>mdi-pencil-box-multiple-outline</v-icon>
                      </v-btn>
                      <component :is="col.ui" v-bind="buildDynCompProps(col, row)"></component>
                    </td>
                  </tr>
                </tbody>
              </template>
            </v-data-table>
          </v-card>
        </v-tab-item>
        <v-tab-item>
          <z-dyna-attr-and-set-editor
            :defines="defines"
            :item="selectedItem"
            :mode="editMode"
            edit-for="Set"
            @itemUpdated="itemUpdated"
          ></z-dyna-attr-and-set-editor>
          <z-dyna-attri-set-attrs-manager
            v-if="selectedItem && selectedItem.id > 0"
            :model="model"
            :id="selectedItem.id"
          ></z-dyna-attri-set-attrs-manager>
        </v-tab-item>
      </v-tabs>
    </v-flex>
  </v-layout>
</template>

<script>
export default {
  data() {
    return {
      baseRoute: "/admin/store-dynamic-attribute-sets",
      filter: true,
      search: "",
      defines: [],
      data: [],
      newModelTemp: {},
      model: "",
      selectedItem: null,
      editMode: "new",
      tab: 0,
      editorTab: false
    };
  },
  created() {
    this.fetchDefines();
    this.initBreadCrumbs();
    this.handleRoute();
  },
  methods: {
    initBreadCrumbs() {
      this.$store.dispatch("CLEAR_BREADCRUMBS", null);
      this.$store.dispatch("ADD_BREADCRUMB_ITEM", {
        text: "Store Dyanmic Attribute Set",
        href: this.baseRoute
      });
      this.$store.dispatch("ADD_BREADCRUMB_ITEM", {
        text: "All",
        href: this.baseRoute
      });
    },

    navToModel(model) {
      if (this.model !== model) {
        this.editorTab = false;
        this.search = "";
      }
      this.$router.push({ query: { model: `${model}` } }).catch(err => {});
    },

    fetchDefines() {
      this.$store.dispatch("SHOW_SPINNER", "Fetching Defines...");
      axios
        .get("/api/v1/admin/metadata/datatable-schemas/dynamic-attribute-sets")
        .then(response => {
          this.$store.dispatch("HIDE_SPINNER");
          if (response && response.success) {
            this.defines = response.data;
          }
        });
    },

    fetchDynamicAttributeSets(modelName) {
      this.model = modelName;
      this.$store.dispatch("SHOW_SPINNER", "Fetching Attribute Set...");
      this.$store.dispatch("REPLACE_BREADCRUMB_LAST_ITEM", {
        text: this.model,
        href: `${this.baseRoute}?model=${modelName}`
      });
      axios
        .get(`/api/v1/admin/dynamic-attribute-sets/models/${modelName}`)
        .then(response => {
          this.$store.dispatch("HIDE_SPINNER");
          if (response && response.success) {
            this.data = response.data;
            this.newModelTemp = response.default;
          }
        });
    },

    handleRoute() {
      if (this.$route.query["model"] !== undefined) {
        this.fetchDynamicAttributeSets(this.$route.query["model"]);
      }
    },

    editAttributeSet(item) {
      this.selectedItem = item;
      this.editMode = "edit";
      this.editorTab = true;
      this.tab = 1;
    },

    newAttributeSet() {
      this.editMode = "new";
      this.selectedItem = JSON.parse(JSON.stringify(this.newModelTemp));
      this.selectedItem.id = 0;
      this.editorTab = true;
      this.tab = 1;
    },

    closeEditorTab() {
      this.editorTab = false;
    },

    closeDialog(result) {
      if (result.success) {
        let item = this.data.find(item => item.id == result.data.id);
        if (item !== undefined) {
          Object.assign(item, result.data);
        } else {
          this.data.push(result.data);
        }
      }
    },
    buildDynCompProps(columDefines, rowItem) {
      var data = Object.assign({}, columDefines);
      data.value = rowItem[columDefines.value];
      data.accessor = columDefines.value;
      return data;
    },
    itemUpdated(item) {
      Object.assign(this.selectedItem, item);
      if (this.editMode === "new") {
        this.editMode = "edit";
        this.fetchDynamicAttributeSets(this.model);
      }
    }
  },
  watch: {
    $route() {
      this.handleRoute();
    }
  }
};
</script>
