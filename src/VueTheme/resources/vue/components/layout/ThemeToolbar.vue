<template>
    <div>
        <!-- <v-app-bar hide-on-scroll> -->
        <v-app-bar app>
            <v-app-bar-nav-icon
                icon
                @click.stop="drawer = !drawer"
            ></v-app-bar-nav-icon>
            <!-- logo -->
            <a href="/">
                <v-img :src="logo" :max-height="45" :contain="true"></v-img>
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

            <!-- mini shopping cart -->
            <v-menu bottom v-if="!user.is_guest">
                <template v-slot:activator="{ on }">
                    <v-btn icon v-on="on">
                        <v-icon color="purple">mdi-account</v-icon>
                    </v-btn>
                </template>
                <v-card class="mx-auto" max-width="344" max-height="400">
                    <v-card-text>{{ user.name }} </v-card-text>
                    <v-card-actions>
                        <v-btn
                            color="blue-grey"
                            class="ma-2 white--text"
                            href="/logout"
                            @click="logout"
                        >
                            Log out
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-menu>

            <!-- mini shopping cart -->
            <v-menu right>
                <template v-slot:activator="{ on }">
                    <v-badge color="purple" class="v-badge-pos-adjust">
                        <v-btn icon v-on="on">
                            <v-icon color="grey">mdi-cart</v-icon>
                        </v-btn>
                        <template v-slot:badge v-if="cart">
                            <span>{{ cart.items_quantity }}</span>
                        </template>
                    </v-badge>
                </template>
                <mini-cart-card :cart="cart"></mini-cart-card>
            </v-menu>
        </v-app-bar>

        <v-navigation-drawer
            v-model="drawer"
            absolute
            temporary
            class="fixed-position"
        >
            <navigation-drawer @signin="signin">
                <template>
                    <slot name="navigation_drawer"></slot>
                </template>
            </navigation-drawer>
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
                    <v-btn
                        depressed
                        style="height:98%"
                        color="primary"
                        @click.stop="btnSearchClick"
                    >
                        <v-icon>mdi-magnify</v-icon>
                    </v-btn>
                </v-flex>
            </v-layout>
        </v-container>

        <!-- breadcump slot -->
        <slot name="breadcrumbs"></slot>

        <v-dialog v-model="signinDialog" persistent max-width="600px">
            <signin-signup
                is-dialog
                @disgard="signinDialog = false"
                work-mode="signin"
            >
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
        },
        logo: {
            type: String
        }
    },
    data() {
        return {
            searchText: this.$store.state.searchResult.criteria.text,
            drawer: false,
            searcher: false,
            signinDialog: false
        };
    },

    methods: {
        onClick(e, item) {
            e.stopPropagation();
            if (item.to || !item.href) return;
            this.$vuetify.goTo(item.href);
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
        right: -1px !important;
        top: 0 !important;
    }
}
.mobile-special-container {
    margin-top: -30px !important;
}
.fixed-position {
    position: fixed;
}
</style>
