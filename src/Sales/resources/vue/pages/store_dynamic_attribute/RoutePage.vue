<template>
    <v-layout>
        <v-dialog v-model="dialog" max-width="960">
            <dynamic-attribute-edit-dialogbody
                :defines="defines"
                :item="selectedItem"
                :mode="dialogMode"
                @close="closeDialog"
            >
            </dynamic-attribute-edit-dialogbody>
        </v-dialog>

        <v-flex md2>
            <v-expansion-panels v-model="pannel" accordion multiple mandatory>
                <v-expansion-panel>
                    <v-expansion-panel-header text-left>
                        Dynamic Attributes
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <v-list-item>
                            <a @click.stop="navToGroup('categories')">
                                Category Model
                            </a>
                        </v-list-item>
                        <v-list-item>
                            <a @click.stop="navToGroup('products')">
                                Product Model
                            </a>
                        </v-list-item>
                        <v-list-item>
                            <a @click.stop="navToGroup('customers')">
                                Customer Model
                            </a>
                        </v-list-item>
                    </v-expansion-panel-content>
                </v-expansion-panel>
            </v-expansion-panels>
        </v-flex>
        <v-flex md10>
            <v-card v-if="!!group">
                <v-card-title>
                    <span class="text-uppercase">{{ label }} </span>
                    <v-btn icon color="error" @click="newAttribute">
                        <v-icon>mdi-plus-circle</v-icon>
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-text-field
                        v-model="search"
                        append-icon="mdi-search"
                        label="Search"
                        single-line
                        hide-details
                    ></v-text-field>
                </v-card-title>
                <v-data-table :headers="defines" :items="data" :search="search">
                    <template v-slot:item.attribute_name="{ item }">
                        <v-btn icon @click="editAttribute(item)">
                            <v-icon>mdi-settings</v-icon>
                            {{ item.attribute_name }}
                        </v-btn>
                    </template>
                    <template v-slot:item.enabled="{ item }">
                        <v-chip
                            filter
                            :input-value="item.enabled"
                            :color="item.enabled ? 'success' : 'error'"
                        >
                            {{ item.enabled ? "Yes" : "No" }}
                        </v-chip>
                    </template>
                    <template v-slot:item.single="{ item }">
                        <v-chip
                            filter
                            :input-value="item.single"
                            :color="item.single ? 'success' : 'error'"
                        >
                            {{ item.single ? "Yes" : "No" }}
                        </v-chip>
                    </template>

                    <template v-slot:item.with_value_map="{ item }">
                        <v-chip
                            filter
                            :input-value="item.with_value_map"
                            :color="item.with_value_map ? 'success' : 'error'"
                        >
                            {{ item.with_value_map ? "Yes" : "No" }}
                        </v-chip>
                    </template>

                    <template v-slot:item.is_search_layer="{ item }">
                        <v-chip
                            filter
                            :input-value="item.is_search_layer"
                            :color="item.is_search_layer ? 'success' : 'error'"
                        >
                            {{ item.is_search_layer ? "Yes" : "No" }}
                        </v-chip>
                    </template>
                </v-data-table>
            </v-card>
            <v-container v-if="!group">
                <span color="error">Please select Model first</span>
            </v-container>
        </v-flex>
    </v-layout>
</template>

<script>
export default {
    data() {
        return {
            dialog: false,
            filter: true,
            search: "",
            baseRoute: "/admin/store-dynamic-attributes",
            defines: [],
            data: [],
            group: "",
            label: "Attributes",
            selectedItem: null,
            dialogMode: "new",
            pannel: [0]
        };
    },
    created() {
        this.fetchDefines();
        this.initBreadCrumbs();
        this.handleRoute();
    },
    methods: {
        initBreadCrumbs() {
            this.$store.dispatch("clearBreadcrumbs", null);
            this.$store.dispatch("addBreadcrumbItem", {
                text: "Store Dyanmic Attributes",
                href: this.baseRoute
            });
            this.$store.dispatch("addBreadcrumbItem", {
                text: "All",
                href: this.baseRoute
            });
        },

        navToGroup(group) {
            this.$router.push({ query: { group: `${group}`}}).catch(err => {});
        },

        fetchDefines() {
            this.$store.dispatch("showSpinner", "Fetching Defines...");
            axios
                .get("/api/v1/admin/configs/groups/tables/dynamicattributes")
                .then(response => {
                    this.$store.dispatch("hideSpinner");
                    if (response.data && response.data.success) {
                        this.defines = response.data.data.table.items;
                        console.log("defines", this.defines);
                    }
                });
        },

        fetchDynamicAttributes(groupName) {
            this.group = groupName;
            switch (groupName) {
                case "categories":
                    this.label = "Category Model";
                    break;
                case "products":
                    this.label = "Product Model";
                    break;
                case "customers":
                    this.label = "Customer Model";
                    break;
            }
            this.$store.dispatch(
                "showSpinner",
                "Fetching Dynamic Attributes..."
            );
            this.$store.dispatch("replaceBreadcrumbLastItem", {
                text: this.group,
                href: `${this.baseRoute}?group=${groupName}`
            });
            axios
                .get(`/api/v1/admin/dynamicattributes/${groupName}`)
                .then(response => {
                    this.$store.dispatch("hideSpinner");
                    if (response.data && response.data.success) {
                        this.data = response.data.data;
                        console.log("data", this.data);
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
                this.fetchDynamicAttributes(this.$route.query["group"]);
            }
        },

        editAttribute(item) {
            this.selectedItem = item;
            this.dialogMode = "edit";
            this.dialog = true;
        },
        newAttribute() {
            this.dialogMode = "edit";
            this.selectedItem = {
                parent_table: this.parent_table,
                id: 0
            };
            this.dialog = true;
        },

        closeDialog(ignore) {
            this.dialog = false;
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
</style>
