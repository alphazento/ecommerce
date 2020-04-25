import {
  CLEAR_BREADCRUMBS,
  ADD_BREADCRUMB_ITEM,
  REPLACE_BREADCRUMB_LAST_ITEM
} from "../actions";

const state = {
  breadcrumbs: [],
};

const getters = {
  getBreadCrumbs: state => state.breadcrumbs
};

const actions = {
  [CLEAR_BREADCRUMBS]: ({
    commit
  }) => {
    commit(CLEAR_BREADCRUMBS);
  },

  [ADD_BREADCRUMB_ITEM]: ({
    commit
  }, item) => {
    commit(ADD_BREADCRUMB_ITEM);
  },

  [REPLACE_BREADCRUMB_LAST_ITEM]: ({
    commit
  }, item) => {
    commit(REPLACE_BREADCRUMB_LAST_ITEM, item);
  },
};

const mutations = {
  [CLEAR_BREADCRUMBS]: state => {
    state.breadcrumbs = [{
      text: 'Dashboard',
      href: '/admin/dashboard',
    }];
  },
  [ADD_BREADCRUMB_ITEM]: (state, item) => {
    state.breadcrumbs.push(item);
  },
  [REPLACE_BREADCRUMB_LAST_ITEM]: (state, item) => {
    state.breadcrumbs.pop();
    state.breadcrumbs.push(item);
  },
};

export default {
  state,
  getters,
  actions,
  mutations
};