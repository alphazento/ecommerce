import {
    BIND_CUSTOMER
} from "../actions";

const state = {
    customer: {
        id: 0,
        group_id: 0,
        is_guest: 1,
        email: "",
        name: ""
    }
};

const getters = {
    isGuest: state => !state.customer || state.customer.is_guest,
    customer: state => state.customer
};

const actions = {
    [BIND_CUSTOMER]: ({
        commit,
        dispatch
    }, customer) => {
        commit(BIND_CUSTOMER, customer);
    },
};

const mutations = {
    [BIND_CUSTOMER]: (state, customer) => {
        state.customer = customer;
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};
