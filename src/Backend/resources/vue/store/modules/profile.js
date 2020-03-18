import {
  PROFILE_REQUEST,
  PROFILE_SUCCESS,
  PROFILE_ERROR
} from "../actions";

import {
  AUTH_LOGOUT
} from "../actions";

const state = {
  profile: JSON.parse(localStorage.getItem("user") || "{}")
};

const getters = {
  userProfile: state => state.profile,
  isProfileLoaded: state => !!state.profile.email
};

const actions = {
  [PROFILE_REQUEST]: ({
    commit,
    dispatch
  }) => {
    axios.get("/api/v1/admin/acl/administrator/me")
      .then(response => {
        commit(PROFILE_SUCCESS, response.data);
      })
      .catch(err => {
        commit(PROFILE_ERROR);
        // if resp is unauthorized, logout, to
        dispatch(AUTH_LOGOUT);
        console.log('AUTH_LOGOUT', err);
      });
  }
};

const mutations = {
  [PROFILE_SUCCESS]: (state, user) => {
    state.profile = user;
    localStorage.setItem('user', JSON.stringify(user));
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