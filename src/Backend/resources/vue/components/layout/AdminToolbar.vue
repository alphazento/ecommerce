<template>
  <div>
    <v-navigation-drawer
      v-model="drawer"
      app
      dark
      :mini-variant.sync="mini"
      :permanent="drawer"
      class="fixed-position"
      v-if="!!userProfile.email"
    >
      <v-list-item>
        <v-list-item-avatar>
          <v-btn icon>
            <v-icon large color="blue darken-2">mdi-view-dashboard</v-icon>
          </v-btn>
        </v-list-item-avatar>
        <v-list-item-title>Dashboard</v-list-item-title>
        <v-btn icon @click.stop="mini = !mini">
          <v-icon>mdi-chevron-left</v-icon>
        </v-btn>
      </v-list-item>
      <!-- Side Menus-->
      <v-expansion-panels accordion multiple>
        <v-expansion-panel v-for="(item, name) in menus" :key="name">
          <v-expansion-panel-header
            text-left
            class="assign-drawer-item"
            :class="hasSubItemSelected(item)"
          >
            <v-list-item>
              <v-list-item-avatar>
                <v-btn icon>
                  <v-icon large color="blue darken-2">{{ item.icon }}</v-icon>
                </v-btn>
              </v-list-item-avatar>
              <v-list-item-title>{{ item.text }}</v-list-item-title>
            </v-list-item>
          </v-expansion-panel-header>
          <v-expansion-panel-content :class="hasSubItemSelected(item)">
            <v-list-item
              v-for="(subItem, i) of item.items"
              :key="i"
              :class="subMenuSelected(subItem)"
            >
              <v-icon v-if="subItem.icon" color="blue darken-2">{{ subItem.icon }}</v-icon>
              <router-link :to="subItem.url" class="white--text">
                {{
                subItem.text
                }}
              </router-link>
            </v-list-item>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
    </v-navigation-drawer>

    <!-- breadcump slot -->

    <!-- <v-app-bar hide-on-scroll> -->
    <v-app-bar app>
      <v-app-bar-nav-icon icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <!-- logo -->
      <a href="/admin">
        <img :src="logo" style="max-height:60px" />
      </a>
      <z-breadcrumbs divider=">"></z-breadcrumbs>
      <v-spacer></v-spacer>

      <!-- account -->
      <v-btn icon @click.stop="signin">
        <v-icon color="grey">mdi-account-circle</v-icon>
      </v-btn>
    </v-app-bar>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      menus: {},
      drawer: true,
      mini: false,
      urlPath: "",
      logo: window.appData.theme.logo
    };
  },

  mounted() {
    this.fetchMenus();
    this.urlPath = this.$route.path;
  },

  methods: {
    fetchMenus() {
      axios.get("/api/v1/admin/dashboard/menus").then(response => {
        if (response.success) {
          this.menus = response.data;
        }
      });
    },
    onClick(e, item) {
      // this.$vuetify.goTo(item.href);
    },
    hasSubItemSelected(item) {
      let found = Object.values(item.items).find(subItem => {
        return this.urlPath == subItem.url;
      });
      return found ? "cyan" : "";
    },
    subMenuSelected(subItem) {
      return this.urlPath == subItem.url ? "pink" : "";
    }
  },
  computed: {
    ...mapGetters(["userProfile"])
  },
  watch: {
    $route() {
      this.urlPath = this.$route.path;
    }
  }
};
</script>

<style>
.v-navigation-drawer--mini-variant
  > .v-navigation-drawer__content
  > .v-expansion-panels
  > .v-expansion-panel
  > .v-expansion-panel-content {
  display: none !important;
}
.assign-drawer-item {
  padding-left: 0 !important;
}
</style>
