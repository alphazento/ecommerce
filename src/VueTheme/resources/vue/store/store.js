import Vuex from 'vuex'
import Axios from 'axios';
import {
    isString
} from 'util';
window.Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        consts: {},
        spinnerOverlay: {
            absolute: false,
            opacity: 0.76,
            overlay: false,
            text: "",
            snack: false
        },

        swatches: {},

        user: {
            id: 0,
            group_id: 0,
            is_guest: 1,
            email: "",
            name: ""
        },
        cart: {
            items: []
        },
        searchResult: {
            aggregate: {},
            criteria: {
                text: ""
            },
            items: [],
            current_page: 1,
            from: 1,
            last_page: 1,
            per_page: 15,
            to: 1,
            total: 1
        },
        //only use for pagination component
        pagination: {
            page: 1,
            sort_by: "position,desc",
            per_page: 30
        },

        pageData: {
            catalog_search_uri: "",
            title: ""
        },
    },
    getters: {

    },
    mutations: {
        setConsts(state, consts) {
            state.consts = consts;
        },
        setSwatches(state, swatches) {
            state.swatches = swatches;
        },

        setCart(state, cart) {
            state.cart = cart;
        },

        setUser(state, user) {
            state.user = user
        },
        controlSpinnerLayer(state, newValues) {
            Object.assign(state.spinnerOverlay, newValues);
        },
        setSearchResult(state, newValues) {
            state.searchResult = newValues;
            state.pagination.page = Number(newValues.current_page);
            state.pagination.per_page = Number(newValues.per_page);
        },
        setPageData(state, values) {
            state.pageData = values;
        },
        updatePagination(state, pagination) {
            var val = Object.assign({}, state.pagination, pagination);
            state.pagination = val;
        }
    },
    actions: {
        setConsts({
            commit
        }, consts) {
            commit('setConsts', consts)
        },

        setSwatches({
            commit
        }, swatches) {
            commit('setSwatches', swatches)
        },

        assignSearchResult({
            commit
        }, data) {
            commit('setSearchResult', data)
        },

        loadCart({
            commit
        }) {
            // this.dispatch('showSpinner', "Loading shopping cart")
            axios.get('/api/v1/cart').then(response => {
                // this.dispatch('hideSpinner')
                if (response && response.success) {
                    commit('setCart', response.data)
                }
            });
        },

        updateCart({
            commit
        }, cart) {
            commit('setCart', cart)
        },

        setUser({
            commit
        }, user) {
            commit('setUser', user)
        },

        postGuestUser({
            commit
        }, user) {
            return new Promise((resolve, reject) => {
                axios.put('/ajax/checkout/guest/details', user).then(response => {
                    commit('setUser', response.data)
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
                    console.log('setCart', response)
                    commit('setCart', response.data)
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
                    commit('setCart', response.data)
                    resolve(response);
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
                    commit('setCart', response.data)
                    resolve(response);
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
                snack: false,
                text: text
            });
        },

        hideSpinner({
            commit
        }) {
            commit('controlSpinnerLayer', {
                overlay: false
            });
        },

        snackMessage({
            commit
        }, text) {
            commit('controlSpinnerLayer', {
                overlay: false,
                snack: true,
                text: text
            });
        },

        controlSpinnerLayer({
            commit
        }, newO) {
            commit('controlSpinnerLayer', newO);
        },

        updatePagination({
            commit
        }, pagination) {
            commit('updatePagination', pagination);
        },

        setPageData({
            commit
        }, values) {
            commit('setPageData', values);
        }
    }
})