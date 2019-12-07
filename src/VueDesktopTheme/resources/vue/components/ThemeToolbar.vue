<template>
  <div>
    <!-- <v-app-bar hide-on-scroll> -->
    <v-app-bar app hide-on-scroll>
      <v-app-bar-nav-icon icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-spacer></v-spacer>
      <v-img :src="logo" :max-height="60" :contain="true"></v-img>
      <v-spacer></v-spacer>

      <!--remove solo-inverted, 
        append-icon="mdi-magnify"
      attr from v-text-field-->
      <v-text-field
        v-if="searcher"
        v-model="searchText"
        flat
        hide-details
        style="max-width: 300px;"
        placeholder="Search..."
        @keyup.native="onEnterKey"
      />
      <v-btn icon @click.stop="btnSearchClick">
        <v-icon>mdi-magnify</v-icon>
      </v-btn>

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
            <v-img src="https://randomuser.me/api/portraits/men/78.jpg"></v-img>
          </v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title>John Leider</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item>
          <v-list-item-avatar>
            <v-img src="https://randomuser.me/api/portraits/men/78.jpg"></v-img>
          </v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title>John Leider</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-divider></v-divider>
        <v-list-item v-for="item in items" :key="item.title" link>
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
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
</style>