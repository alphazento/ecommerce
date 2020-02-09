import CategoryRoutePage from "./pages/catalog/category/RoutePage";
import ProductRoutePage from "./pages/catalog/product/RoutePage";

export default {
    components: {
        "category-treeview": "components/CategoryTreeview.vue",
        "catalog-model-editor": "components/ModelEditor.vue",
    },
    routes: [{
        name: "catalog.category",
        path: "/admin/catalog/category",
        component: CategoryRoutePage
    }, {
        name: "catalog.product",
        path: "/admin/catalog/product",
        component: ProductRoutePage
    }]
}
