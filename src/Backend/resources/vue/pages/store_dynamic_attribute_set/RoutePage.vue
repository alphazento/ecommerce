<template>
  <v-layout>
    <v-flex md2>
      <v-expansion-panels value="0" accordion mandatory>
        <v-expansion-panel>
          <v-expansion-panel-header text-left>Dynamic Attribute Set</v-expansion-panel-header>
          <v-expansion-panel-content>
            <v-list-item>
              <a @click.stop="navToGroup('Category')">For Category</a>
            </v-list-item>
            <v-list-item>
              <a @click.stop="navToGroup('Product')">For Product</a>
            </v-list-item>
            <v-list-item>
              <a @click.stop="navToGroup('Cutomer')">For Customer</a>
            </v-list-item>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
    </v-flex>

    <v-flex md10>
      <v-tabs v-model="tab" v-if="!!group">
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
                <v-icon>mdi-plus-circle</v-icon>New Attribute Set
              </v-btn>
            </v-list-item>
          </v-list>
        </v-menu>

        <v-tab>
          <v-icon left>mdi-lock</v-icon>
          <span>All Attribute Sets of {{group}}</span>
        </v-tab>
        <v-tab v-if="editorTab">
          <v-icon left>mdi-lock</v-icon>
          <span class="error" v-if="editMode=='new'">New Attribute Set</span>
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
                      <v-btn v-if="ci == 0" icon @click="editAttributeSet(row)" color="primary">
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
          <z-dynamic-attribute-and-set-editor
            :defines="defines"
            :item="selectedItem"
            :mode="editMode"
            edit-for="Set"
          ></z-dynamic-attribute-and-set-editor>
          <z-dynamic-attribute-set-binding :model="group" :id="selectedItem.id" v-if="selectedItem && selectedItem.id>0"></z-dynamic-attribute-set-binding>
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
      group: "",
      label: "Attributes",
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
        text: "Store Dyanmic Attribute Set",
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
        .get("/api/v1/admin/configs/groups/tables/dynamic-attribute-sets")
        .then(response => {
          this.$store.dispatch("hideSpinner");
          if (response.data && response.data.success) {
            this.defines = response.data.data.table.items;
          }
        });
    },

    fetchDynamicAttributes(groupName) {
      this.group = groupName;
      this.label = groupName;
      this.$store.dispatch("showSpinner", "Fetching Attribute Set...");
      this.$store.dispatch("replaceBreadcrumbLastItem", {
        text: this.group,
        href: `${this.baseRoute}?group=${groupName}`
      });
      axios
        .get(`/api/v1/admin/dynamic-attribute-sets/models/${groupName}`)
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
