import {
  PROFILE_REQUEST,
  PROFILE_SUCCESS,
  PROFILE_ERROR
} from "../actions";

import {
  AUTH_LOGOUT
} from "../actions";

const state = {
  profile: {}
};

const getters = {
  userProfile: state => state.profile,
  isProfileLoaded: state => !!state.profile.is_guest
};

const actions = {
  [PROFILE_REQUEST]: ({
    commit,
    dispatch
  }) => {
    axios.get("/api/v1/admin/acl/administrator/users/me")
      .then(resp => {
        commit(PROFILE_SUCCESS, resp);
      })
      .catch(err => {
        commit(PROFILE_ERROR);
        // if resp is unauthorized, logout, to
        dispatch(AUTH_LOGOUT);
      });
  }
};

const mutations = {
  [PROFILE_SUCCESS]: (state, resp) => {
    console.log(PROFILE_SUCCESS, resp);
    state.profile = resp;
  },
  [PROFILE_ERROR]: state => {},
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