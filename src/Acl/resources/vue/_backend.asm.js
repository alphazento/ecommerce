import BackendACLRoutePage from "./pages/backend/RoutePage";

export default {
    components: {
        "z-acl-role-list": "components/RoleList.vue",
    },
    routes: [{
        name: "catalog.category",
        path: "/admin/acl/backend",
        component: BackendACLRoutePage,
        meta: {
            title: 'Backend ACL Admin'
        }
    }]
}
