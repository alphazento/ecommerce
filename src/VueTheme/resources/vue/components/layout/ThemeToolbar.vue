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
      <v-btn icon @click.stop="signin" v-if="isGuest">
        <v-icon color="grey">mdi-account-circle</v-icon>
      </v-btn>

      <v-menu bottom v-else>
        <template v-slot:activator="{ on }">
          <v-btn icon v-on="on">
            <v-icon color="purple">mdi-account</v-icon>
          </v-btn>
        </template>
        <v-card class="mx-auto" max-width="344" max-height="400">
          <v-card-text>{{ customer.name }}</v-card-text>
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
        :value="!quoteIsEmpty"
        @click.native="showShoppingCartDrawer"
      >
        <template v-slot:badge>
          <span>{{ quote.items_quantity }}</span>
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
      <mini-cart-card :cart="quote" v-model="shoppingCartDrawer"></mini-cart-card>
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
import { mapGetters } from "vuex";

export default {
  props: {
    links: {
      type: Array
    }
  },
  data() {
    return {
      searchText: this.searchKeyword,
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
        if (!this.quoteIsEmpty) this.shoppingCartDrawer = true;
      }
    }
  },
  computed: {
    ...mapGetters([
      "searchKeyword",
      "searchResult",
      "quote",
      "quoteIsEmpty",
      "customer",
      "isGuest"
    ])
  },
  created() {
    if (!this.quoteInited) {
      this.$store.dispatch("LOAD_QUOTE_REQUEST");
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
