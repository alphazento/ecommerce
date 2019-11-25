<template>
    <v-card>
        <v-expansion-panels accordion multiple>
            <v-expansion-panel
                v-for="(item, key) in pagination.aggregate"
                :key="key"
            >
                <v-expansion-panel-header text-left>
                    <span>{{ item.label }}</span>
                </v-expansion-panel-header>
                <v-expansion-panel-content>
                    <component
                        :is="filterBullet(key)"
                        v-bind="item"
                    ></component>
                </v-expansion-panel-content>
            </v-expansion-panel>
        </v-expansion-panels>
    </v-card>
</template>

<script>
export default {
    props: {},
    data() {
        return {
            fav: true,
            menu: false,
            message: false,
            hints: true
        };
    },
    computed: {
        pagination() {
            return this.$store.state.searchResult;
        }
    },
    methods: {
        filterBullet(name) {
            switch (name) {
                case "price":
                    return "price-filter-bullet";
                case "category":
                    return "category-filter-bullet";
                    break;
                default:
                    return "switch-filter-bullet";
                    break;
            }
        }
    },
    watch: {
        $route() {
            console.log("changed", this.$route);
        }
    }
};
</script>
