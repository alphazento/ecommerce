import {
  SET_THEME_DATA,
  CLEAR_BREADCRUMBS,
  ADD_BREADCRUMB_ITEM,
  REPLACE_BREADCRUMB_LAST_ITEM
} from "../actions";

const state = {
  breadcrumbs: [],
  themeData: {
    footer: {},
    logo: ''
  }
};

const getters = {
  getBreadCrumbs: state => state.breadcrumbs,
  themeSettings: state => state.themeData
};

const actions = {
  [SET_THEME_DATA]: ({
    commit
  }, values) => {
    commit('SET_THEME_DATA', values)
  },

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
  [SET_THEME_DATA]: (state, values) => {
    state.themeData = values;
  },

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