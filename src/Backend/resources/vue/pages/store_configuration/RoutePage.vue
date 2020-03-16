<template>
  <v-layout>
    <v-flex md3>
      <v-expansion-panels accordion v-if="menus" focusable>
        <v-expansion-panel v-for="(item, name) in menus" :key="name">
          <v-expansion-panel-header text-left>{{ item.text }}</v-expansion-panel-header>
          <v-expansion-panel-content>
            <v-list-item v-for="(subItem, subName) in item.items" :key="subName">
              <a @click.stop="navToGroup(name, subName)">
                {{
                subItem.text
                }}
              </a>
            </v-list-item>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
    </v-flex>
    <v-flex md9>
      <config-model-editor :model="model" @configValueChanged="configValueChanged"></config-model-editor>
    </v-flex>
  </v-layout>
</template>

<script>
export default {
  data() {
    return {
      dataKey: "store_config_menus",
      menus: undefined,
      baseRoute: "/admin/store-configurations",
      model: ""
    };
  },
  created() {
    this.calcMenus();
    if (this.menus === undefined) {
      this.fetchMenus();
    }
    this.initBreadCrumbs();
    this.handleRoute();
  },
  methods: {
    initBreadCrumbs() {
      this.$store.dispatch("CLEAR_BREADCRUMBS", null);
      this.$store.dispatch("ADD_BREADCRUMB_ITEM", {
        text: "Store Configurations",
        href: this.baseRoute
      });
      this.$store.dispatch("ADD_BREADCRUMB_ITEM", {
        text: "All",
        href: this.baseRoute
      });
    },
    calcMenus() {
      if (sessionStorage.getItem('config_menus') !== undefined) {
        this.menus = sessionStorage.getItem('config_menus');
      }
    },
    fetchMenus() {
      this.$store.dispatch("showSpinner", "Loading configurations");
      axios.get("/api/v1/admin/configs/menus").then(response => {
        this.$store.dispatch("hideSpinner");
        if (response.data && response.data.success) {
          sessionStorage.setItem('config_menus', response.data.data);
          this.calcMenus();
        } else {
          this.model = "";
        }
      });
    },

    navToGroup(group, subName) {
      this.$router
        .push({ query: { group: `${group}/${subName}` } })
        .catch(err => {});
    },

    configValueChanged(item) {
      this.$store.dispatch("showSpinner", "Updating...");
      axios
        .post(`/api/v1/admin/configs/${item.accessor}`, {
          value: item.value,
          is_json: item.is_json
        })
        .then(response => {
          this.$store.dispatch("hideSpinner");
        });
    },

    handleRoute() {
      if (this.$route.query["group"] !== undefined) {
        this.model = this.$route.query["group"];
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

