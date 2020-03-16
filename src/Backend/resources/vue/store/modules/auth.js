/* eslint-disable promise/param-names */
import {
  AUTH_REQUEST,
  AUTH_ERROR,
  AUTH_SUCCESS,
  AUTH_LOGOUT,
  PROFILE_REQUEST
} from "../actions";
import Axios from "axios";

const state = {
  token: localStorage.getItem("user-token") || "",
  hasLoadedOnce: false
};

const getters = {
  isAuthenticated: state => !!state.token,
  authStatus: state => state.status
};

const actions = {
  [AUTH_REQUEST]: ({
    commit,
    dispatch
  }, user) => {
    // user: username, password
    return new Promise((resolve, reject) => {
      commit(AUTH_REQUEST);
      axios.post("/api/v1/admin/oauth2/token", user)
        .then(resp => {
          localStorage.setItem("user-token", resp.token);
          commit(AUTH_SUCCESS, resp);
          dispatch(PROFILE_REQUEST);
          resolve(resp);
        })
        .catch(err => {
          commit(AUTH_ERROR, err);
          localStorage.removeItem("user-token");
          reject(err);
        });
    });
  },
  [AUTH_LOGOUT]: ({
    commit
  }) => {
    return new Promise(resolve => {
      commit(AUTH_LOGOUT);
      localStorage.removeItem("user-token");
      resolve();
    });
  }
};

const mutations = {
  [AUTH_REQUEST]: state => {},
  [AUTH_SUCCESS]: (state, resp) => {
    state.token = resp.token;
    state.hasLoadedOnce = true;
  },
  [AUTH_ERROR]: state => {
    state.hasLoadedOnce = true;
  },
  [AUTH_LOGOUT]: state => {
    state.token = "";
  }
};

export default {
  state,
  getters,
  actions,
  mutations
};