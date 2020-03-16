import Vuex from 'vuex'

import profile from "./modules/profile";
import auth from "./modules/auth";
import app from "./modules/app";
import spinerlayer from "./modules/spinerlayer";

import {
    isString
} from 'util';
window.Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        app,
        auth,
        profile,
        spinerlayer
    },
    strict: true
})