import Vuex from 'vuex'
import Axios from 'axios';
import {
    isString
} from 'util';
window.Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        swatches: {},

        pageData: {
            uri: "",
            title: ""
        },
    },
    mutations: {
        setSwatches(state, swatches) {
            state.swatches = swatches;
        },

        setPageData(state, values) {
            state.pageData = values;
        },
    },
    actions: {
        setSwatches({
            commit
        }, swatches) {
            commit('setSwatches', swatches)
        },

        setPageData({
            commit
        }, values) {
            commit('setPageData', values);
        }
    }
})
