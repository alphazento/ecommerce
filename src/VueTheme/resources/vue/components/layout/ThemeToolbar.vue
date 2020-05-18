<template>
  <div>
    <!-- <v-app-bar hide-on-scroll> -->
    <v-app-bar app>
      <v-app-bar-nav-icon icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <!-- logo -->
      <a href="/">
        <img :src="logo" style="max-height:45px" />
      </a>
      <!-- category menus -->
      <v-spacer></v-spacer>

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

      <!-- account -->
      <v-btn icon @click.stop="signin" v-if="!!user.is_guest">
        <v-icon color="grey">mdi-account-circle</v-icon>
      </v-btn>

      <v-menu bottom v-if="!user.is_guest">
        <template v-slot:activator="{ on }">
          <v-btn icon v-on="on">
            <v-icon color="purple">mdi-account</v-icon>
          </v-btn>
        </template>
        <v-card class="mx-auto" max-width="344" max-height="400">
          <v-card-text>{{ user.name }}</v-card-text>
          <v-card-actions>
            <v-btn color="blue-grey" class="ma-2 white--text" href="/logout" @click="logout">Log out</v-btn>
          </v-card-actions>
        </v-card>
      </v-menu>

      <!-- shopping cart -->
      <v-badge
        color="purple"
        class="v-badge-pos-adjust"
        bordered
        offset-x="10"
        offset-y="10"
        :value="cart && cart.items_quantity > 0"
        @click.native="showShoppingCartDrawer"
      >
        <template v-slot:badge>
          <span>{{ cart.items_quantity }}</span>
        </template>
        <v-btn icon>
          <v-icon color="grey">mdi-cart</v-icon>
        </v-btn>
      </v-badge>
    </v-app-bar>

    <v-navigation-drawer v-model="drawer" absolute temporary class="fixed-position">
      <navigation-drawer @signin="signin">
        <template>
          <slot name="navigation_drawer"></slot>
        </template>
      </navigation-drawer>
    </v-navigation-drawer>

    <v-navigation-drawer v-model="shoppingCartDrawer" temporary right floating fixed width="360px">
      <mini-cart-card :cart="cart" v-model="shoppingCartDrawer"></mini-cart-card>
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

    <v-dialog v-model="signinDialog" persistent max-width="600px">
      <signin-signup is-dialog @disgard="closeDialog" work-mode="signin">
        <template>
          <slot name="sns_login"></slot>
        </template>
      </signin-signup>
    </v-dialog>
  </div>
</template>

<script>
export default {
  props: {
    links: {
      type: Array
    }
  },
  data() {
    return {
      searchText: this.$store.state.searchResult.criteria.text,
      drawer: false,
      shoppingCartDrawer: false,
      searcher: false,
      signinDialog: false,
      logo: window.appData.theme.logo
    };
  },

  methods: {
    onClick(e, item) {
      e.stopPropagation();
      if (item.to || !item.href) return;
      this.$vuetify.goTo(item.href);
    },

    closeDialog() {
      this.signinDialog = false;
    },

    canSearch() {
      this.searchText = this.searchText ? this.searchText.trim() : "";
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
    signin(event) {
      event && event.preventDefault();
      this.signinDialog = true;
      this.drawer = false;
    },
    logout(event) {
      event && event.preventDefault();
    },
    showShoppingCartDrawer() {
      if (this.shoppingCartDrawer) {
        this.shoppingCartDrawer = false;
      } else {
        if (this.cart && this.cart.items_quantity > 0)
          this.shoppingCartDrawer = true;
      }
    }
  },
  computed: {
    cart() {
      return this.$store.state.cart;
    },
    user() {
      return this.$store.state.user;
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
    left: 30px !important;
    top: 5px !important;
  }
}
.mobile-special-container {
  margin-top: -30px !important;
}
.fixed-position {
  position: fixed;
}
</style>
