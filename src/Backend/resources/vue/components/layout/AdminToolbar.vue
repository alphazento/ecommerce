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
                        <v-icon large color="blue darken-2"
                            >mdi-view-dashboard</v-icon
                        >
                    </v-btn>
                </v-list-item-avatar>
                <v-list-item-title>Dashboard</v-list-item-title>
                <v-btn icon @click.stop="mini = !mini">
                    <v-icon>mdi-chevron-left</v-icon>
                </v-btn>
            </v-list-item>
            <v-expansion-panels accordion multiple>
                <v-expansion-panel>
                    <v-expansion-panel-header
                        text-left
                        class="assign-drawer-item"
                    >
                        <v-list-item>
                            <v-list-item-avatar>
                                <v-btn icon>
                                    <v-icon large color="blue darken-2"
                                        >mdi-store</v-icon
                                    >
                                </v-btn>
                            </v-list-item-avatar>
                            <v-list-item-title>Store</v-list-item-title>
                        </v-list-item>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <v-list-item>
                            <router-link to="/admin/store-configurations"
                                >Configuration</router-link
                            >
                        </v-list-item>
                        <v-list-item>
                            <router-link to="/admin/store-dynamic-attributes"
                                >Dynamic Attributes</router-link
                            >
                        </v-list-item>
                    </v-expansion-panel-content>
                </v-expansion-panel>

                <v-expansion-panel>
                    <v-expansion-panel-header
                        text-left
                        class="assign-drawer-item"
                    >
                        <v-list-item>
                            <v-list-item-avatar>
                                <v-btn icon>
                                    <v-icon large color="blue darken-2"
                                        >mdi-warehouse</v-icon
                                    >
                                </v-btn>
                            </v-list-item-avatar>
                            <v-list-item-title>Catalog</v-list-item-title>
                        </v-list-item>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                        content
                    </v-expansion-panel-content>
                </v-expansion-panel>

                <v-expansion-panel>
                    <v-expansion-panel-header
                        text-left
                        class="assign-drawer-item"
                    >
                        <v-list-item>
                            <v-list-item-avatar>
                                <v-btn icon>
                                    <v-icon large color="blue darken-2"
                                        >mdi-warehouse</v-icon
                                    >
                                </v-btn>
                            </v-list-item-avatar>
                            <v-list-item-title>Sales</v-list-item-title>
                        </v-list-item>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <v-list-item>
                            <router-link to="/admin/sales_orders"
                                >Orders</router-link
                            >
                        </v-list-item>
                    </v-expansion-panel-content>
                </v-expansion-panel>
            </v-expansion-panels>
        </v-navigation-drawer>

        <!-- breadcump slot -->

        <!-- <v-app-bar hide-on-scroll> -->
        <v-app-bar app>
            <v-app-bar-nav-icon
                icon
                @click.stop="drawer = !drawer"
            ></v-app-bar-nav-icon>
            <!-- logo -->
            <a href="/admin">
                <v-img
                    src="https://upload.wikimedia.org/wikipedia/commons/0/0b/Alphago_logo_Reversed.svg"
                    :max-height="45"
                    :contain="true"
                ></v-img>
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
            drawer: true,
            mini: false
        };
    },

    methods: {
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
