import Vuex from 'vuex'
import Axios from 'axios';
window.Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        consts: {},
        userInfo: {
            email: "tony@tonercity.com.au"
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
        setShippingAddress({
            commit
        }, address) {
            var cartId = this.state.cart.guid;
            var url = `/api/v1/cart/${cartId}/shipping_address`;
            axios.put(url, {
                address: address
            }).then(response => {
                console.log('set shipping address', response)
            });
        }
    }
})