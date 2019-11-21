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
        cart: {
            items: []
        },
        spinnerOverlay: {
            absolute: false,
            opacity: 0.76,
            overlay: false,
            text: ""
        }
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
        },
        controlSpinnerLayer(state, newValues) {
            Object.assign(state.spinnerOverlay, newValues);
        }
    },
    actions: {
        initConsts({
            commit
        }, consts) {
            commit('setConsts', consts)
        },

        loadCart({
            commit
        }) {
            this.dispatch('showSpinner', "Loading shopping cart")
            axios.get('/api/v1/cart').then(response => {
                this.dispatch('hideSpinner')
                if (response.data && response.data.status === 200) {
                    commit('setCart', response.data.data)
                }
            });
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
            var url = '/api/v1/checkout/guest-customer';
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
            var url = `/api/v1/cart/shipping_address`;
            return new Promise((resolve, reject) => {
                axios.put(url, address).then(response => {
                    console.log('setCart', response.data)
                    commit('setCart', response.data.data)
                    resolve(response);
                }, error => {
                    reject(error);
                });
            });
        },

        updateCartItemQty({
            commit
        }, item) {
            var url = `/api/v1/cart/items/${item.id}/quantity/${item.quantity}`;
            return new Promise((resolve, reject) => {
                this.dispatch('showSpinner', "Updating shopping cart")
                axios.patch(url).then(response => {
                    commit('setCart', response.data.data)
                    resolve(response.data);
                    this.dispatch('hideSpinner')
                }, error => {
                    reject(error);
                });
            });
        },
        deleteCartItem({
            commit
        }, item) {
            var url = `/api/v1/cart/items/${item.id}`;
            return new Promise((resolve, reject) => {
                this.dispatch('showSpinner', "Deleing shopping cart item")
                axios.delete(url).then(response => {
                    commit('setCart', response.data.data)
                    resolve(response.data);
                    this.dispatch('hideSpinner')
                }, error => {
                    reject(error);
                });
            });
        },

        showSpinner({
            commit
        }, text) {
            commit('controlSpinnerLayer', {
                overlay: true,
                text: text
            });
        },

        hideSpinner({
            commit
        }) {
            commit('controlSpinnerLayer', {
                overlay: false,
            });
        }
    }
})