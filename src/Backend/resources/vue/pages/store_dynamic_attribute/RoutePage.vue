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
              <v-btn color="error" @click="newAttribute" v-if="editMode != 'new' || !attributeTab">
                <v-icon>mdi-plus-circle</v-icon>New Attribute
              </v-btn>
            </v-list-item>
          </v-list>
        </v-menu>

        <v-tab>
          <v-icon left>mdi-lock</v-icon>
          <span>All Attributes of {{group}}</span>
        </v-tab>
        <v-tab v-if="attributeTab">
          <v-icon left>mdi-lock</v-icon>
          <span class="error" v-if="editMode=='new'">New Attribute</span>
          <span v-else>{{selectedItem.attribute_name}}</span>
          <v-btn icon color="error" @click="closeProductTab">
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
                      <component :is="col.ui" v-bind="ui_component_props(col, row)"></component>
                    </td>
                  </tr>
                </tbody>
              </template>
            </v-data-table>
          </v-card>
        </v-tab-item>
        <v-tab-item>
          <dynamic-attribute-editor-dialogbody
            :defines="defines"
            :item="selectedItem"
            :mode="editMode"
            @close="closeDialog"
          ></dynamic-attribute-editor-dialogbody>
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
      attributeTab: false
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
      this.$router.push({ query: { group: `${group}` } }).catch(err => {});
    },

    fetchDefines() {
      this.$store.dispatch("showSpinner", "Fetching Defines...");
      axios
        .get("/api/v1/admin/configs/groups/tables/dynamicattributes")
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
        .get(`/api/v1/admin/dynamicattributes/models/${groupName}`)
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
      this.attributeTab = true;
      this.tab = 1;
    },
    newAttribute() {
      this.editMode = "new";
      this.selectedItem = JSON.parse(JSON.stringify(this.newModelTemp));
      this.selectedItem.id = 0;
      this.attributeTab = true;
      this.tab = 1;
    },

    closeProductTab() {
      this.attributeTab = false;
    },

    closeDialog(result) {
      this.attributeTab = false;
      if (result.success) {
        let item = this.data.find(item => item.id == result.data.id);
        if (item !== undefined) {
          Object.assign(item, result.data);
        } else {
          this.data.push(result.data);
        }
      }
    },

    ui_component_props(columDefines, rowItem) {
      var data = Object.assign({}, columDefines);
      data.value = rowItem[columDefines.value];
      data.accessor = columDefines.value;
      return data;
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
