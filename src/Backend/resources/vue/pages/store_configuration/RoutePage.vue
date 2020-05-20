<template>
  <v-layout>
    <v-flex md3>
      <v-expansion-panels accordion v-if="menus" focusable>
        <v-expansion-panel v-for="(item, name) in menus" :key="name">
          <v-expansion-panel-header text-left :class="hasSubItemSelected(item)">{{ item.text }}</v-expansion-panel-header>
          <v-expansion-panel-content :class="hasSubItemSelected(item)">
            <v-list-item
              v-for="(subItem, subName) in item.items"
              :key="subName"
              :class="subMenuSelected(item, subName, subItem)"
            >
              <a @click.stop="navToGroup(name, subName)">{{ subItem.text }}</a>
            </v-list-item>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
    </v-flex>
    <v-flex md9>
      <config-model-editor
        :model="modelGroup"
        model-define-from="configs/groups"
        @configValueChanged="configValueChanged"
      ></config-model-editor>
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
      modelGroup: ""
    };
  },
  created() {
    this.calcMenus();
    if (!this.menus) {
      this.fetchConfigMenus();
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
      if (sessionStorage.getItem("config_menus") !== undefined) {
        this.menus = JSON.parse(sessionStorage.getItem("config_menus"));
      }
    },
    fetchConfigMenus() {
      this.$store.dispatch("SHOW_SPINNER", "Loading configurations");
      axios.get("/api/v1/admin/configs/config-menus").then(response => {
        this.$store.dispatch("HIDE_SPINNER");
        if (response && response.success) {
          sessionStorage.setItem("config_menus", JSON.stringify(response.data));
          this.calcMenus();
        } else {
          this.modelGroup = "";
        }
      });
    },

    navToGroup(group, subName) {
      this.$router
        .push({ query: { group: `${group}/${subName}` } })
        .catch(err => {});
    },

    configValueChanged(item) {
      this.$store.dispatch("SHOW_SPINNER", "Updating...");
      axios
        .post(`/api/v1/admin/configs/${item.accessor}`, {
          value: item.value,
          is_json: item.is_json
        })
        .then(response => {
          this.$store.dispatch("HIDE_SPINNER");
        });
    },

    handleRoute() {
      if (this.$route.query["group"] !== undefined) {
        this.modelGroup = this.$route.query["group"];

        this.$store.dispatch("REPLACE_BREADCRUMB_LAST_ITEM", {
          text: this.modelGroup,
          href: this.$route.fullPath
        });
      }
    },

    hasSubItemSelected(item) {
      let found = Object.keys(item.items).find(subName => {
        return (
          this.modelGroup.toLowerCase() ===
          `${item.text}/${subName}`.toLowerCase()
        );
      });
      return found ? "cyan" : "";
    },
    subMenuSelected(item, subName, subItem) {
      if (
        this.modelGroup.toLowerCase() ===
        `${item.text}/${subName}`.toLowerCase()
      ) {
        return "pink";
      }
      return "";
    }
  },
  watch: {
    $route() {
      this.handleRoute();
    }
  }
};
</script>

