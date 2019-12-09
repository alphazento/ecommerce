<template>
  <div>
    <!-- <v-app-bar hide-on-scroll> -->
    <v-app-bar app >
      <v-app-bar-nav-icon icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-spacer></v-spacer>

      <!-- logo -->
      <v-img :src="logo" :max-height="60" :contain="true"></v-img>

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
      <!-- search button -->
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

      <!-- category menus -->
      <template v-slot:extension>
        <v-container>
          <v-tabs
              v-model="tab"
              align-with-title
              background-color="transparent"
              v-on:change="onNavmenuChange"
              @click.native="onNavmenuClick"
            >
            <v-tabs-slider color="deep-purple"></v-tabs-slider>
            <v-tab v-for="(item, i) in items" :key="i" class="nav-menu-tab">
              {{ item.title }}
            </v-tab>
          </v-tabs>
        </v-container>
      </template>
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

    <div v-if="!category_menu_active">
      <!-- mobile search bar -->
      <v-container class="d-md-none">
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
    <v-container  v-if="category_menu_active">
      <!-- <v-navigation-drawer stateless v-model="category_menu_active" :absolute="false" 
        temporary overlay-opacity="0.01"
        width="100%"> -->
        <v-overlay
          light
          :opacity="0.01"
          :value="category_menu_active"
          class="category_menu_overlay"
          @click.native="overlayClick"
        >
          <v-card light>
            <v-system-bar light  height="35">
                <v-spacer></v-spacer>
                <v-btn
                    icon
                    @click="category_menu_active = false"
                >
                  <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-system-bar>
            <v-container>
            <slot v-bind:tab="tab" name="category_menus"></slot>
            </v-container>
          </v-card>
        </v-overlay>
      <!-- </v-navigation-drawer> -->
    </v-container>

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
      if ("v-overlay__content" === e.srcElement.className || "v-overlay__scrim" === e.srcElement.className) {
        this.category_menu_active = false;
      }
    },
    onClick(e, item) {
      e.stopPropagation();
      if (item.to || !item.href) return;
      this.$vuetify.goTo(item.href);
    },

    canSearch() {
      this.searchText = this.searchText.trim();
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
      console.log('nav item tab change', this.category_menu_active)
    },
    onNavmenuClick() {
      if (!this.category_menu_changed) {
        this.category_menu_active = !this.category_menu_active;
      } else {
        this.category_menu_active = !this.category_menu_active;
        this.category_menu_active = !this.category_menu_active;
      }
      this.category_menu_changed = false;
      console.log('nav item tab onNavmenuClick', this.category_menu_active)
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
.v-badge-pos-adjust {
  .v-badge__badge {
    right: -1px !important;
    top: 0 !important;
  }
}
.nav-menu-tab {
  margin-left: 0 !important;
}
.category_menu_overlay {
    align-items: unset !important;
    overflow:hidden;
    padding-top: 110px;
    .v-overlay__content {
      width:100%;
    }
}

  .departments-dropdown {
      width: 1440px;
  }
  .category-list {
      position: relative;
      width: 200px;
      display: inline-block;
      background-color: #f0f0f0;
      min-height: 440px;
  }

  .item-category-list {
      display: block;
      margin-top: 20px;
  }

  .category-item {
      display: block;
      width: 100%;
      transition: all .3s ease;
      background: linear-gradient(to right,transparent 50%,#fff 50%);
      background-position: left bottom;
      background-size: 200% 100%;
      height:35px;
      font-size: 16px;
      .category-label {
          font-family: novecentowidedemi,sans-serif;
          font-size: .75rem;
          text-transform: uppercase;
          -webkit-font-smoothing: antialiased;
          -moz-osx-font-smoothing: grayscale;
          display: block;
          padding: 10px;
          color: #92bcba;
          text-decoration: none;
          height: 15px;
          line-height: 17px;
      }
  }
  .dropdown-column {
      float: left;
      width: 25%;
      box-sizing: border-box;
  }

  .sub-category-wrap .header-image-box {
      float: right;
      display: block;
      min-height: 300px;
      padding-left: 5px;
      height: 100%;
      width: 200px;
  }

  .category-item.active, .category-item:hover {
      background-position: right bottom;
  }
  
  .category-item.active .sub-category-wrap {
      display: block;
  }

  .sub-category-wrap {
      display: none;
      background-color: #fff;
      position: absolute;
      left: 100%;
      top: 0;
      width: 1200px;
      box-sizing: border-box;
      padding: 12px 0 0 12px;
    .dropdown-column {
      margin-left: 9px;
      margin-right: 9px;
      padding-left: 5px;
      padding-right: 5px;
    }
    .sub-category-content {
       display: flex;
    }
  }

  .sub-category-wrap.nav-col-3 .dropdown-column {
      width: 33%;
  }

  .sub-category-list {
      margin-bottom: 25px;
  }

  .sub-category-item {
      font-size: .8125rem;
      margin-bottom: 20px;
      position: relative;
      line-height: 1.28;
      list-style: none;
      .sub-category-label {
        font-weight: 700;
        text-decoration: none;
        position: relative;
        display: inline-block;
        width: 100%;
      }
  }

  .item-category-list li {
      display: block;
      margin-bottom: 10px;
       a {
        text-decoration: none;
        width: auto;
        position: relative;
    }
  }
</style>