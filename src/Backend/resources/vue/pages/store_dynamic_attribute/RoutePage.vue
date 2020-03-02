<template>
  <v-layout>
    <v-flex md2>
      <v-expansion-panels value="0" accordion mandatory>
        <v-expansion-panel>
          <v-expansion-panel-header text-left>Dynamic Attributes</v-expansion-panel-header>
          <v-expansion-panel-content>
            <v-list-item>
              <a @click.stop="navToGroup('Category')">Category Model</a>
            </v-list-item>
            <v-list-item>
              <a @click.stop="navToGroup('Product')">Product Model</a>
            </v-list-item>
            <v-list-item>
              <a @click.stop="navToGroup('Customer')">Customer Model</a>
            </v-list-item>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
    </v-flex>
    <v-flex md10>
      <v-tabs v-model="tab"  v-if="!!group">
        <v-menu bottom right>
          <template v-slot:activator="{ on }">
            <v-btn text class="align-self-center mr-4" v-on="on">
              more
              <v-icon right>mdi-menu-down</v-icon>
            </v-btn>
          </template>
          <v-list class="grey lighten-3">
            <v-list-item>
              <v-btn color="error" @click="newAttribute" v-if="editMode != 'new' || !editorTab">
                <v-icon>mdi-plus-circle</v-icon>New Attribute
              </v-btn>
            </v-list-item>
          </v-list>
        </v-menu>

        <v-tab>
          <v-icon left>mdi-lock</v-icon>
          <span>All Attributes of {{group}}</span>
        </v-tab>
        <v-tab v-if="editorTab">
          <v-icon left>mdi-lock</v-icon>
          <span class="error" v-if="editMode=='new'">New Attribute</span>
          <span v-else>{{selectedItem.name}}</span>
          <v-btn icon color="error" @click="closeEditorTab">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-tab>

        <v-tab-item>
          <v-card v-if="!!group">
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
                      <v-btn v-if="ci == 0" icon @click="editAttribute(row)" color="primary">
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
          <z-dynamic-attribute-and-set-editor
            :defines="defines"
            :item="selectedItem"
            :mode="editMode"
            @itemUpdated="itemUpdated"
          ></z-dynamic-attribute-and-set-editor>

          <z-dynamic-attribute-value-map-manager v-if="selectedItem && selectedItem.with_value_map" :id="selectedItem.id" :is-swatch="!!selectedItem.swatch">
          </z-dynamic-attribute-value-map-manager>
        </v-tab-item>
      </v-tabs>
    </v-flex>
  </v-layout>
</template>

<script>
export default {
  data() {
    return {
      search: "",
      baseRoute: "/admin/store-dynamic-attributes",
      defines: [],
      data: [],
      newModelTemp: {},
      group: "",
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
      this.$store.dispatch("clearBreadcrumbs", null);
      this.$store.dispatch("addBreadcrumbItem", {
        text: "Store Dyanmic Attributes",
        href: this.baseRoute
      });
      this.$store.dispatch("addBreadcrumbItem", {
        text: "All",
        href: this.baseRoute
      });
    },

    navToGroup(group) {
      if (this.group !== group) {
        this.editorTab = false;
      }
      this.$router.push({ query: { group: `${group}` } }).catch(err => {});
    },

    fetchDefines() {
      this.$store.dispatch("showSpinner", "Fetching Defines...");
      axios
        .get("/api/v1/admin/configs/groups/tables/dynamic-attributes")
        .then(response => {
          this.$store.dispatch("hideSpinner");
          if (response.data && response.data.success) {
            this.defines = response.data.data.table.items;
          }
        });
    },

    fetchDynamicAttributes(groupName) {
      this.group = groupName;
      this.$store.dispatch("showSpinner", "Fetching Dynamic Attributes...");
      this.$store.dispatch("replaceBreadcrumbLastItem", {
        text: this.group,
        href: `${this.baseRoute}?group=${groupName}`
      });
      axios
        .get(`/api/v1/admin/dynamic-attributes/models/${groupName}`)
        .then(response => {
          this.$store.dispatch("hideSpinner");
          if (response.data && response.data.success) {
            this.data = response.data.data;
            this.newModelTemp = response.data.default;
          }
        });
    },

    handleRoute() {
      if (this.$route.query["group"] !== undefined) {
        this.fetchDynamicAttributes(this.$route.query["group"]);
      }
    },

    editAttribute(item) {
      this.selectedItem = item;
      this.editMode = "edit";
      this.editorTab = true;
      this.tab = 1;
    },
    newAttribute() {
      this.editMode = "new";
      this.selectedItem = JSON.parse(JSON.stringify(this.newModelTemp));
      this.selectedItem.id = 0;
      this.editorTab = true;
      this.tab = 1;
    },

    closeEditorTab() {
      this.editorTab = false;
    },

    buildDynCompProps(columDefines, rowItem) {
      var data = Object.assign({}, columDefines);
      data.value = rowItem[columDefines.value];
      data.accessor = columDefines.value;
      return data;
    },
    itemUpdated(item) {
      console.log('itemUpdated', item);
      Object.assign(this.selectedItem, item);
    }
  },
  watch: {
    $route() {
      this.handleRoute();
    }
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
</style>
