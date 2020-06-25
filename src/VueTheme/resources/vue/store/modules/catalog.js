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
    SET_PRODUCT_ATTR_CONTAINERS,
    SELECT_ATTR_CONTAINER,
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
    attrContainers: []
};

const getters = {
    searchKeyword: state => state.dataset.criteria.text,
    searchResult: state => state.dataset,
    paginationFilter: state => state.paginationFilter,
    attrContainers: state => state.attrContainers,
};

const actions = {
    [CATALOG_SEARCH_REQUEST]: ({
        commit,
        dispatch
    }, url) => {
        return new Promise((resolve, reject) => {
            dispatch(SHOW_SPINNER, "Updating...");
            axios.get(url).then(response => {
                if (response && response.success) {
                    commit(CATALOG_SEARCH_SUCCESS, response.data);
                } else {
                    //snak_message
                    dispatch(SNACK_MESSAGE, 'catalog search failed.');
                }
                resolve(response);
                dispatch("HIDE_SPINNER");
            }).catch(err => {
                dispatch("HIDE_SPINNER");
                dispatch(SNACK_MESSAGE, 'catalog search failed.');
                reject(err);
            });
        });
    },

    [CATALOG_SEARCH_SUCCESS]: ({
        commit
    }, data) => {
        commit(CATALOG_SEARCH_SUCCESS, data);
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
    },

    [SET_PRODUCT_ATTR_CONTAINERS]: ({
        commit
    }, data) => {
        commit(SET_PRODUCT_ATTR_CONTAINERS, data);
    },

    [SELECT_ATTR_CONTAINER]: ({
        commit
    }, item) => {
        commit(SELECT_ATTR_CONTAINER, item);
    }
};

const mutations = {
    [CATALOG_SEARCH_SUCCESS]: (state, dataset) => {
        state.dataset = dataset;
        state.paginationFilter = {
            per_page: Number(dataset.per_page),
            page: Number(dataset.current_page),
            sort_by: dataset.criteria.sort_by ? dataset.criteria.sort_by : state.paginationFilter.sort_by
        }
    },
    [CATALOG_SEARCH_PAGINATE_TO]: (state, page) => {
        state.paginationFilter = {
            per_page: state.paginationFilter.per_page,
            page: Number(page),
            sort_by: state.paginationFilter.sort_by
        }
    },

    [CATALOG_SEARCH_PAGINATE_PER_PAGE]: (state, per_page) => {
        state.paginationFilter = {
            per_page: Number(per_page),
            page: state.paginationFilter.page,
            sort_by: state.paginationFilter.sort_by
        }
    },
    [CATALOG_SEARCH_SORT_BY]: (state, sortby) => {
        state.paginationFilter = {
            per_page: state.paginationFilter.per_page,
            page: state.paginationFilter.page,
            sort_by: sortby
        }
    },
    [SET_PRODUCT_ATTR_CONTAINERS]: (state, data) => {
        state.attrContainers = data;
    },
    [SELECT_ATTR_CONTAINER]: (state, item) => {
        if (state.attrContainers[item.attr]) {
            state.attrContainers[item.attr].current = item.value;
        }
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};
