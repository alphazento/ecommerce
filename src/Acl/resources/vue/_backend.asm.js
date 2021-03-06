import BackendACLRoutePage from "./pages/backend/RoutePage";

export default {
    components: {
        "z-acl-role-list": "components/RoleList.vue",
        "z-route-assign-management": "components/RouteAssignView.vue",
        "z-role-relationship-management": "components/RoleRelationShipManagement.vue",
        "z-user-relationship-management": "components/UserRelationShipManagement.vue",
        'z-role-users-management': "components/RoleUserManagement.vue",
    },
    routes: [{
        name: "acl.backend",
        path: "/admin/acl/backend",
        component: BackendACLRoutePage,
        meta: {
            title: 'Backend ACL Admin'
        }
    }]
}
