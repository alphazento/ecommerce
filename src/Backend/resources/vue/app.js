/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
window.Vue = require('vue');

import VueRouter from 'vue-router';
// window.VueRouter = VueRouter;
window.vStore = require('./store/store.js');
window.Vue.use(VueRouter);

import StoreConfigurationPage from "./pages/store_configuration/RoutePage";
import StoreDynamicAttributePage from "./pages/store_dynamic_attribute/RoutePage";
import SalesOrdersPage from "./pages/sales_orders/RoutePage";

window.router = new VueRouter({
    mode: 'history',
    routes: [{
            name: "store.configuration",
            path: "/admin/store-configurations",
            component: StoreConfigurationPage
        },
        {
            name: "store.dynamic_attributes",
            path: "/admin/store-dynamic-attributes",
            component: StoreDynamicAttributePage
        },
        {
            name: "sales.orders",
            path: "/admin/sales_orders",
            component: SalesOrdersPage
        }
    ]
});
require('./._app.dev');
