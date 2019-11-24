/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
window.Vue = require('vue');

import VueRouter from 'vue-router';
import SearchResultRoutePage from "./components/catalog/search/SearchResultRoutePage"
window.VueRouter = VueRouter;
window.SearchResultRoutePage = SearchResultRoutePage;
window.vStore = require('./store/store.js');
window.Vue.use(VueRouter);
require('./._app.dev');
