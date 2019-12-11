<template>
  <div>
    <!-- <v-app-bar hide-on-scroll> -->
    <v-app-bar app>
      <v-app-bar-nav-icon icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <!-- logo -->
      <v-img :src="logo" :max-height="45" :contain="true"></v-img>
      <!-- category menus -->

      <div class="d-none d-md-block">
        <slot name="category_menus"></slot>
      </div>
      <v-spacer></v-spacer>

      <!-- desktop search bar -->
      <v-text-field
        v-if="searcher"
        v-model="searchText"
        flat
        hide-details
        style="max-width: 300px;"
        placeholder="Search..."
        @keyup.native="onEnterKey"
        class="d-none d-md-block"
      />
      <!-- search button desktop-->
      <v-btn icon @click.stop="btnSearchClick" class="d-none d-md-block">
        <v-icon>mdi-magnify</v-icon>
      </v-btn>

      <!-- mini shopping cart -->
      <v-menu left bottom>
        <template v-slot:activator="{ on }">
          <v-badge color="purple" class="v-badge-pos-adjust">
            <v-btn icon v-on="on">
              <v-icon color="grey">mdi-cart</v-icon>
            </v-btn>
            <template v-slot:badge v-if="cart">
              <span>{{cart.items_quantity}}</span>
            </template>
          </v-badge>
        </template>
        <mini-cart-card :cart="cart"></mini-cart-card>
      </v-menu>
    </v-app-bar>

    <v-navigation-drawer v-model="drawer" absolute temporary>
      <v-list dense nav>
        <v-list-item>
          <v-list-item-avatar>
            <v-icon color="grey">mdi-account</v-icon>
          </v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title>Account</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title>Orders</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title>Buy Again</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-divider></v-divider>
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title>Home</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title>Today's Deals</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title>Shop By Categories</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <!-- mobile search bar -->
    <v-container class="d-md-none mobile-special-container">
      <v-layout>
        <slot name="category_menus"></slot>
      </v-layout>
      <v-layout>
        <v-flex xs10>
          <v-text-field
            v-model="searchText"
            flat
            hide-details
            solo
            outlined
            placeholder="Search..."
            @keyup.native="onEnterKey"
          />
        </v-flex>
        <v-flex xs2>
          <v-btn depressed style="height:98%" color="primary" @click.stop="btnSearchClick">
            <v-icon>mdi-magnify</v-icon>
          </v-btn>
        </v-flex>
      </v-layout>
    </v-container>

    <!-- breadcump slot -->
    <slot name="breadcrumbs"></slot>
  </div>
</template>

<script>
export default {
  name: "toolbar",
  props: {
    links: {
      type: Array
    },
    logo: {
      type: String
    },
    cartApi: {
      type: String
    }
  },
  data() {
    return {
      tab: null,
      category_menu_active: false,
      category_menu_inited: false,
      category_menu_changed: false,
      searchText: this.$store.state.searchResult.criteria.text,
      drawer: false,
      searcher: false,
      items: [
        { title: "Home", icon: "dashboard" },
        { title: "About", icon: "question_answer" }
      ]
    };
  },

  methods: {
    overlayClick(e) {
      if (
        "v-overlay__content" === e.srcElement.className ||
        "v-overlay__scrim" === e.srcElement.className
      ) {
        this.category_menu_active = false;
      }
    },
    onClick(e, item) {
      e.stopPropagation();
      if (item.to || !item.href) return;
      this.$vuetify.goTo(item.href);
    },

    canSearch() {
      this.searchText = this.searchText ? this.searchText.trim() : '';
      return this.searchText.length > 2;
    },

    onEnterKey(e) {
      if (e.isTrusted && e.code === "Enter" && this.canSearch()) {
        window.location.href =
          "/search?text=" + encodeURIComponent(this.searchText);
      }
    },
    btnSearchClick() {
      if (this.searcher && this.canSearch()) {
        window.location.href =
          "/search?text=" + encodeURIComponent(this.searchText);
      }
      this.searcher = !this.searcher;
    },
    onNavmenuChange() {
      if (!this.category_menu_inited) {
        this.category_menu_inited = true;
      } else {
        this.category_menu_active = true;
        this.category_menu_changed = true;
      }
      console.log("nav item tab change", this.category_menu_active);
    },
    onNavmenuClick() {
      if (!this.category_menu_changed) {
        this.category_menu_active = !this.category_menu_active;
      } else {
        this.category_menu_active = !this.category_menu_active;
        this.category_menu_active = !this.category_menu_active;
      }
      this.category_menu_changed = false;
      console.log("nav item tab onNavmenuClick", this.category_menu_active);
    }
  },
  computed: {
    cart() {
      return this.$store.state.cart;
    }
  },
  created() {
    if (!this.cart || !this.cart.uuid) {
      this.$store.dispatch("loadCart");
    }
  }
};
</script>

<style lang="scss">
@import "./navigator.scss";
.v-badge-pos-adjust {
  .v-badge__badge {
    right: -1px !important;
    top: 0 !important;
  }
}
.mobile-special-container {
  margin-top: -30px !important;
}
</style>