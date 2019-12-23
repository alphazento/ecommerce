<template>
    <v-layout>
        <v-flex md3>
            <v-expansion-panels accordion v-if="menus" focusable>
                <v-expansion-panel v-for="(item, name) in menus" :key="name">
                    <v-expansion-panel-header text-left>
                        {{ item.title }}
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <v-list-item
                            v-for="(subItem, subName) in item.items"
                            :key="subName"
                        >
                            <a @click.stop="navToGroup(name, subName)">{{
                                subItem.title
                            }}</a>
                        </v-list-item>
                    </v-expansion-panel-content>
                </v-expansion-panel>
            </v-expansion-panels>
        </v-flex>
        <v-flex md9>
            <v-expansion-panels accordion multiple focusable>
                <v-expansion-panel
                    v-for="(item, name) in groupData"
                    :key="name"
                >
                    <v-expansion-panel-header text-left>
                        {{ item.title }}
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <v-list-item
                            v-for="(subItem, subName) in item.items"
                            :key="subName"
                        >
                            <v-layout class="bottom-line">
                                <v-flex md3 class="v-middle">
                                    <span>{{ subItem.title }}</span>
                                </v-flex>
                                <v-flex md6>
                                    <div class="component-container">
                                        <component
                                            :is="subItem.ui"
                                            v-bind="subItem"
                                            @valueChanged="configValueChanged"
                                        ></component>
                                    </div>
                                </v-flex>
                                <v-flex md3>
                                    {{ subItem.description }}
                                </v-flex>
                            </v-layout>
                        </v-list-item>
                    </v-expansion-panel-content>
                </v-expansion-panel>
            </v-expansion-panels>
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
            groupData: {}
        };
    },
    created() {
        this.calcMenus();
        if (this.menus === undefined) {
            this.fetchMenus();
        }
        this.initBreadCrumbs();
        this.handleRoute();
    },
    methods: {
        initBreadCrumbs() {
            this.$store.dispatch("clearBreadcrumbs", null);
            this.$store.dispatch("addBreadcrumbItem", {
                text: "Store Configurations",
                href: this.baseRoute
            });
            this.$store.dispatch("addBreadcrumbItem", {
                text: "All",
                href: this.baseRoute
            });
        },
        calcMenus() {
            if (this.$store.state.cachedData.store_config_menus !== undefined) {
                this.menus = this.$store.state.cachedData.store_config_menus;
            }
        },
        fetchMenus() {
            this.$store.dispatch("showSpinner", "Loading configurations");
            axios.get("/api/v1/admin/configs/menus").then(response => {
                this.$store.dispatch("hideSpinner");
                if (response.data && response.data.success) {
                    this.$store.dispatch("cacheData", {
                        store_config_menus: response.data.data
                    });
                    this.calcMenus();
                } else {
                    this.groupData = {};
                }
            });
        },

        navToGroup(group, subName) {
            this.$router.push({ query: { group: `${group}/${subName}`}}).catch(err => {});
        },

        fetchGroupDetails(groupName) {
            this.$store.dispatch("replaceBreadcrumbLastItem", {
                text: groupName,
                href: `${this.baseRoute}?group=${groupName}`
            });

            this.$store.dispatch("showSpinner", "Loading details");
            axios
                .get(`/api/v1/admin/configs/groups/${groupName}`)
                .then(response => {
                    this.$store.dispatch("hideSpinner");
                    if (response.data && response.data.success) {
                        this.groupData = response.data.data;
                    }
                });
        },

        configValueChanged(item) {
            this.$store.dispatch("showSpinner", "Updating...");
            axios
                .post(`/api/v1/admin/configs/${item.accessor}`, {
                    value: item.value
                })
                .then(response => {
                    this.$store.dispatch("hideSpinner");
                });
        },

        handleRoute() {
            if (this.$route.query["group"] !== undefined) {
                this.fetchGroupDetails(this.$route.query["group"]);
            }
        }
    },
    watch: {
        $route() {
            this.handleRoute();
        }
    }
};
</script>

<style scoped>
.v-middle {
    margin-top: auto;
    margin-bottom: auto;
}
.bottom-line {
    border-bottom: 1px solid grey;
}
.component-container {
    padding-top: 18px;
}
</style>
