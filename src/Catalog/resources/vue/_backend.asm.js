import CategoryRoutePage from "./pages/catalog/category/RoutePage";
import ProductRoutePage from "./pages/catalog/product/RoutePage";

export default {
    components: {
        "category-treeview": "components/CategoryTreeview.vue",
        "z-dyna-attr-model-editor": "components/DAModelEditor.vue"
    },
    routes: [{
        name: "catalog.category",
        path: "/admin/catalog/category",
        component: CategoryRoutePage,
        meta: {
            title: 'Catalog Category'
        }
    }, {
        name: "catalog.product",
        path: "/admin/catalog/product",
        component: ProductRoutePage,
        meta: {
            title: 'Catalog Product'
        }
    }]
}
