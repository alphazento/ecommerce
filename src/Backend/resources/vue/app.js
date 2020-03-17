/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
window.Vue = require('vue');

import VueRouter from 'vue-router';
window.vStore = require('./store/store.js');
window.Vue.use(VueRouter);

var support = require('./._app.support');

function routeGuard(to, from, next) {
    var isAuthenticated = false;
    if (localStorage.getItem('LoggedUser')) {
        next(); // allow to enter route
    } else {
        next('/admin/login'); // go to '/login';
    }
}

import LoginPage from "./pages/auth/LoginPage";

if (support.default.routes && support.default.routes.length > 0) {
    support.default.routes.forEach(route => {
        route.beforeEnter = routeGuard;
    });
    support.default.routes.push({
        name: "store.auth.login",
        path: "/admin/login",
        component: LoginPage
    });

    window.router = new VueRouter({
        mode: 'history',
        routes: support.default.routes
    });
}