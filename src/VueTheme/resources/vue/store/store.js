import Vuex from 'vuex'

import app from "./modules/app";
import catalogSearch from "./modules/catalogSearch";
import checkout from "./modules/checkout";
import customer from "./modules/customer";
import quote from "./modules/quote";
import spinerlayer from "./modules/spinerlayer";

window.Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        app,
        catalogSearch,
        checkout,
        customer,
        quote,
        spinerlayer
    },
    strict: true
})
