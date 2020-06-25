import {
    SHOW_SPINNER,
    HIDE_SPINNER,
    LOAD_QUOTE_REQUEST,
    QUOTE_SUCCESS,
    UPDATE_QUOTE_ITEM_QTY_REQUEST,
    DELETE_QUOTE_ITEM_REQUEST
} from "../actions";

const state = {
    quote: {
        shipping_address: {},
        subtotal: 0,
        grandtotal: 0,
        coupon_codes: '',
        uuid: 'init',
        items: []
    }
};

const getters = {
    quoteIsEmpty: state => !state.quote || state.quote.items.length === 0,
    quote: state => state.quote,
    quoteInited: state => !(!state.quote || state.quote.uuid === 'init')
};

const actions = {
    [LOAD_QUOTE_REQUEST]: ({
        commit
    }) => {
        return new Promise((resolve, reject) => {
            axios.get('/api/v1/cart').then(response => {
                if (response && response.success) {
                    commit(QUOTE_SUCCESS, response.data);
                }
                resolve(response);
            }, err => {
                // commit(QUOTE_ERROR);
                reject(err)
            })
        });
    },


    [QUOTE_SUCCESS]: ({
        commit
    }, quote) => {
        commit(QUOTE_SUCCESS, quote);
    },

    [UPDATE_QUOTE_ITEM_QTY_REQUEST]: ({
        commit,
        dispatch
    }, item) => {
        var url = `/api/v1/cart/items/${item.id}/quantity/${item.quantity}`;
        dispatch(SHOW_SPINNER, "Updating shopping cart");
        axios.patch(url).then(response => {
            commit(QUOTE_SUCCESS, response.data);
            dispatch('HIDE_SPINNER');
        }, error => {
            dispatch('HIDE_SPINNER');
        });
    },

    [DELETE_QUOTE_ITEM_REQUEST]: ({
        commit,
        dispatch
    }, itemId) => {
        var url = `/api/v1/cart/items/${itemId}`;
        dispatch('SHOW_SPINNER', "Deleing shopping cart item");
        axios.delete(url).then(response => {
            commit(QUOTE_SUCCESS, response.data);
            dispatch('HIDE_SPINNER');
        }, error => {
            dispatch('HIDE_SPINNER');
        });
    }
};

const mutations = {
    [QUOTE_SUCCESS]: (state, data) => {
        state.quote = data;
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};
