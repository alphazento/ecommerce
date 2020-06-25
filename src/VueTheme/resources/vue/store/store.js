import Vuex from 'vuex'

import app from "./modules/app";
import catalog from "./modules/catalog";
import checkout from "./modules/checkout";
import customer from "./modules/customer";
import quote from "./modules/quote";
import spinerlayer from "./modules/spinerlayer";

window.Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        app,
        catalog,
        checkout,
        customer,
        quote,
        spinerlayer
    },
    strict: true
})
