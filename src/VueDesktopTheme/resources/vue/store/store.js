import Vuex from 'vuex'
window.Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        consts: {

        },
        userInfo: {
            email: "tony@tonercity.com.au"
        },
    },
    getters: {

    },
    mutations: {
        setConsts(state, consts) {
            state.consts = consts;
        },
        setUserInfo(state, userInfo) {
            state.userInfo = userInfo
        }
    },
    actions: {
        initConsts({
            commit
        }, consts) {
            commit('setConsts', consts)
        }
    }
})