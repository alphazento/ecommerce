<template>
    <v-layout>
        this is an orders page
    </v-layout>
</template>

<script>
export default {
    data() {
        return {
            baseRoute: "/admin/sales_orders",
            groupData: {}
        };
    },
    created() {
        this.initBreadCrumbs();
        this.handleRoute();
    },
    methods: {
        initBreadCrumbs() {
            this.$store.dispatch("clearBreadcrumbs", null);
            this.$store.dispatch("addBreadcrumbItem", {
                text: "Sales.Orders",
                href: this.baseRoute
            });
        },

        handleRoute() {
            if (this.$route.query["group"] !== undefined) {
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
