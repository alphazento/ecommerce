<template>
  <div>
    <v-navigation-drawer
      v-model="drawer"
      app
      dark
      :mini-variant.sync="mini"
      :permanent="drawer"
      class="fixed-position"
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
      <v-expansion-panels accordion multiple>
        <v-expansion-panel v-for="(item, name) in menus" :key="name">
          <v-expansion-panel-header text-left class="assign-drawer-item">
            <v-list-item>
              <v-list-item-avatar>
                <v-btn icon>
                  <v-icon large color="blue darken-2">
                    {{
                    item.icon
                    }}
                  </v-icon>
                </v-btn>
              </v-list-item-avatar>
              <v-list-item-title>
                {{
                item.title
                }}
              </v-list-item-title>
            </v-list-item>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <v-list-item v-for="(subItem, i) of item.items" :key="i">
              <v-icon v-if="subItem.icon" color="blue darken-2">
                {{
                subItem.icon
                }}
              </v-icon>
              <router-link :to="subItem.url" class="white--text">{{ subItem.title }}</router-link>
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
        <v-img :src="$store.state.themeData.logo" :max-height="45" contain :position="'left'"></v-img>
      </a>
      <!-- category menus -->
      <v-spacer></v-spacer>

      <!-- account -->
      <v-btn icon @click.stop="signin" v-if="!!user.is_guest">
        <v-icon color="grey">mdi-account-circle</v-icon>
      </v-btn>
    </v-app-bar>
  </div>
</template>

<script>
export default {
  props: {
    logo: {
      type: String
    }
  },
  data() {
    return {
      menus: {},
      drawer: true,
      mini: false
    };
  },

  mounted() {
    this.fetchMenus();
  },

  methods: {
    fetchMenus() {
      axios.get("/api/v1/admin/dashboard/menus").then(response => {
        if (response.data.success) {
          this.menus = response.data.data;
        }
      });
    },
    onClick(e, item) {
      // this.$vuetify.goTo(item.href);
    }
  },
  computed: {
    user() {
      return this.$store.state.user;
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
