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
if (support.default.routes && support.default.routes.length > 0) {
    window.router = new VueRouter({
        mode: 'history',
        routes: support.default.routes
    });
}
