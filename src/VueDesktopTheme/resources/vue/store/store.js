import Vuex from 'vuex'
import Axios from 'axios';
window.Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        consts: {},
        userInfo: {
            id: 0,
            group_id: 0,
            is_guest: 1,
            email: "",
            name: ""
        },
        cart: {}
    },
    getters: {

    },
    mutations: {
        setConsts(state, consts) {
            state.consts = consts;
        },
        setCart(state, cart) {
            state.cart = cart;
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
        },

        updateCart({
            commit
        }, cart) {
            commit('setCart', cart)
        },

        initUserInfo({
            commit
        }, userInfo) {
            commit('setUserInfo', userInfo)
        },

        setUserInfo({
            commit
        }, userInfo) {
            var url = `/ajax/checkout/guest-customer`;
            return new Promise((resolve, reject) => {
                axios.put(url, userInfo).then(response => {
                    commit('setUserInfo', response.data.data)
                    resolve(response);
                }, error => {
                    reject(error);
                });
            });

        },

        setShippingAddress({
            commit
        }, address) {
            var cartId = this.state.cart.id;
            var url = `/api/v1/cart/shipping_address`;
            return new Promise((resolve, reject) => {
                axios.put(url, address).then(response => {
                    console.log('updateCart', response.data)
                    commit('updateCart', response.data)
                    resolve(response);
                }, error => {
                    reject(error);
                });
            });
        }
    }
})