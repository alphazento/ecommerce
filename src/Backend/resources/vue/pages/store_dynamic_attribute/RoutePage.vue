<template>
  <v-layout>
    <v-dialog v-model="dialog" max-width="960">
      <dynamic-attribute-edit-dialogbody
        :defines="defines"
        :item="selectedItem"
        :mode="dialogMode"
        @close="closeDialog"
      ></dynamic-attribute-edit-dialogbody>
    </v-dialog>

    <v-flex md2>
      <v-expansion-panels v-model="pannel" accordion multiple mandatory>
        <v-expansion-panel>
          <v-expansion-panel-header text-left>Dynamic Attributes</v-expansion-panel-header>
          <v-expansion-panel-content>
            <v-list-item>
              <a @click.stop="navToGroup('categories')">Category Model</a>
            </v-list-item>
            <v-list-item>
              <a @click.stop="navToGroup('products')">Product Model</a>
            </v-list-item>
            <v-list-item>
              <a @click.stop="navToGroup('customers')">Customer Model</a>
            </v-list-item>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
    </v-flex>
    <v-flex md10>
      <v-card v-if="!!group">
        <v-card-title>
          <span class="text-uppercase">{{ label }}</span>
          <v-btn icon color="error" @click="newAttribute">
            <v-icon>mdi-plus-circle</v-icon>
          </v-btn>
          <v-spacer></v-spacer>
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
      <v-container v-else>
        <span color="error">Please select Model first</span>
      </v-container>
    </v-flex>
  </v-layout>
</template>

<script>
export default {
  data() {
    return {
      dialog: false,
      filter: true,
      search: "",
      baseRoute: "/admin/store-dynamic-attributes",
      defines: [],
      data: [],
      newModelTemp: {},
      group: "",
      label: "Attributes",
      selectedItem: null,
      dialogMode: "new",
      pannel: [0]
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
      switch (groupName) {
        case "categories":
          this.label = "Category Model";
          break;
        case "products":
          this.label = "Product Model";
          break;
        case "customers":
          this.label = "Customer Model";
          break;
      }
      this.$store.dispatch("showSpinner", "Fetching Dynamic Attributes...");
      this.$store.dispatch("replaceBreadcrumbLastItem", {
        text: this.group,
        href: `${this.baseRoute}?group=${groupName}`
      });
      axios
        .get(`/api/v1/admin/dynamicattributes/${groupName}`)
        .then(response => {
          this.$store.dispatch("hideSpinner");
          if (response.data && response.data.success) {
            this.data = response.data.data;
            this.newModelTemp = response.data.default;
          }
        });
    },

    configValueChanged(item) {
      this.$store.dispatch("showSpinner", "Updating...");
      axios
        .post(`/api/v1/admin/configs/${item.accessor}`, {
          value: item.value
        })
        .then(response => {
          this.$store.dispatch("hideSpinner");
        });
    },

    handleRoute() {
      if (this.$route.query["group"] !== undefined) {
        this.fetchDynamicAttributes(this.$route.query["group"]);
      }
    },

    editAttribute(item) {
      this.selectedItem = item;
      this.dialogMode = "edit";
      this.dialog = true;
    },
    newAttribute() {
      this.dialogMode = "edit";
      this.selectedItem = JSON.parse(JSON.stringify(this.newModelTemp));
      this.selectedItem.id = 0;
      this.dialog = true;
    },

    closeDialog(ignore) {
      this.dialog = false;
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
