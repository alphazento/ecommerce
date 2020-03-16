import {
  PROFILE_REQUEST,
  PROFILE_ERROR,
  PROFILE_SUCCESS
} from "../actions";

import {
  AUTH_LOGOUT
} from "../actions";

const state = {
  profile: {}
};

const getters = {
  getProfile: state => state.profile,
  isProfileLoaded: state => !!state.profile.name
};

const actions = {
  [PROFILE_REQUEST]: ({
    commit,
    dispatch
  }) => {
    commit(PROFILE_REQUEST);
    axios.get({
        url: "user/me"
      })
      .then(resp => {
        commit(USER_SUCCESS, resp);
      })
      .catch(() => {
        commit(USER_ERROR);
        // if resp is unauthorized, logout, to
        dispatch(AUTH_LOGOUT);
      });
  }
};

const mutations = {
  [PROFILE_REQUEST]: state => {},
  [PROFILE_SUCCESS]: (state, resp) => {
    Vue.set(state, "profile", resp);
  },
  [PROFILE_ERROR]: state => {
    // state.status = "error";
  },
  [AUTH_LOGOUT]: state => {
    state.profile = {};
  }
};

export default {
  state,
  getters,
  actions,
  mutations
};