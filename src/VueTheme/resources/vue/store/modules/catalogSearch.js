/* eslint-disable promise/param-names */
import {
    SHOW_SPINNER,
    HIDE_SPINNER,
    SNACK_MESSAGE,
    CATALOG_SEARCH_REQUEST,
    CATALOG_SEARCH_SUCCESS,
    CATALOG_SEARCH_PAGINATE_TO,
    CATALOG_SEARCH_PAGINATE_PER_PAGE,
    CATALOG_SEARCH_SORT_BY,
} from "../actions";

const state = {
    dataset: {
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
    paginationFilter: {
        page: 1,
        sort_by: "position,desc",
        per_page: 30
    },
};

const getters = {
    searchKeyword: state => state.dataset.criteria.text,
    searchResult: state => state.dataset,
    paginationFilter: state => state.paginationFilter,
};

const actions = {
    [CATALOG_SEARCH_REQUEST]: ({
        commit
    }, url) => {
        return new Promise((resolve, reject) => {
            this.dispatch(SHOW_SPINNER, "Updating...");
            axios.get(url).then(response => {
                if (response && response.success) {
                    commit(CATALOG_SEARCH_SUCCESS, response.data);
                } else {
                    //snak_message
                    this.dispatch(SNACK_MESSAGE, 'catalog search failed.');
                }
                resolve(response);
                this.dispatch("HIDE_SPINNER");
            }).catch(err => {
                this.dispatch("HIDE_SPINNER");
                this.dispatch(SNACK_MESSAGE, 'catalog search failed.');
                reject(err);
            });
        });
    },
    [CATALOG_SEARCH_PAGINATE_TO]: ({
        commit
    }, page) => {
        commit(CATALOG_SEARCH_PAGINATE_TO, page);
    },
    [CATALOG_SEARCH_PAGINATE_PER_PAGE]: ({
        commit
    }, v) => {
        commit(CATALOG_SEARCH_PAGINATE_PER_PAGE, v);
    },

    [CATALOG_SEARCH_SORT_BY]: ({
        commit
    }, v) => {
        commit(CATALOG_SEARCH_SORT_BY, v);
    }
};

const mutations = {
    [CATALOG_SEARCH_SUCCESS]: (state, dataset) => {
        state.dataset = dataset;
    },
    [CATALOG_SEARCH_PAGINATE_TO]: (state, page) => {
        state.paginationFilter.page = Number(page);
    },

    [CATALOG_SEARCH_PAGINATE_PER_PAGE]: (state, per_page) => {
        state.paginationFilter.per_page = Number(per_page);
    },
    [CATALOG_SEARCH_SORT_BY]: (state, sortby) => {
        state.paginationFilter.per_page = Number(sortby);
    },
};

export default {
    state,
    getters,
    actions,
    mutations
};
