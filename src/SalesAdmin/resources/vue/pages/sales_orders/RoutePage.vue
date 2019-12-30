<template>
    <v-container>
        <v-card-title>
            <span>Sales Orders</span>
            <!-- <v-spacer></v-spacer>
            <v-text-field
                v-model="search"
                append-icon="mdi-search"
                label="Search"
                single-line
                hide-details
            ></v-text-field> -->
        </v-card-title>
        <v-data-table
            :headers="defines"
            :items="pagination.data"
            :search="search"
        >
            <template v-slot:body="{ headers, items }">
                <tbody>
                    <tr>
                        <td v-for="(col, ci) of headers" :key="ci">
                            <component
                                v-if="!!col.filter_ui"
                                :is="col.filter_ui"
                                v-bind="filter_ui_component_props(col.value)"
                            ></component>
                        </td>
                    </tr>
                    <tr class="text-start" v-for="(row, i) of items" :key="i">
                        <td v-for="(col, ci) of headers" :key="ci">
                            <component
                                :is="col.ui"
                                v-bind="ui_component_props(col, row)"
                            >
                            </component>
                        </td>
                    </tr>
                </tbody>
            </template>

        </v-data-table>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            search: "",
            defines: [],
            pagination: {
                data: []
            },
            filters: {}
        };
    },
    created() {
        this.fetchDefines();
        this.fetchOrders();
    },
    methods: {
        fetchDefines() {
            this.$store.dispatch("showSpinner", "Fetching Defines...");
            axios
                .get("/api/v1/admin/configs/groups/tables/orders")
                .then(response => {
                    this.$store.dispatch("hideSpinner");
                    if (response.data && response.data.success) {
                        this.defines = response.data.data.table.items;
                        console.log("defines", this.defines);
                        this.defines.forEach(item => {
                            if (item.filterable !== undefined && this.filterable) {
                                this.filters[item.value] = "";
                            }
                        })
                    }
                });
        },

        fetchOrders() {
            this.$store.dispatch("showSpinner", "Fetching Orders...");
            axios.get("/api/v1/admin/sales/orders").then(response => {
                this.$store.dispatch("hideSpinner");
                if (response.data && response.data.success) {
                    this.pagination = response.data.data;
                }
            });
        },

        ui_component_props(columDefines, rowItem) {
            var data = Object.assign({}, columDefines);
            // data.title = columDefines.text;
            data.value = rowItem[columDefines.value];
            data.accessor = columDefines.value;
            data.order = rowItem;
            return data;
        },
        filter_ui_component_props(filterName) {
            var data = {
                accessor: filterName, 
                value: this.filters[filterName] === undefined ? "" : this.filters[filterName],
            };

            return data;
        }
    },
    watch: {
        $route() {}
    }
};
</script>
