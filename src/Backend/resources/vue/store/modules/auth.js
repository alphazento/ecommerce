/* eslint-disable promise/param-names */
import {
  AXIOS_AUTH_INTERCEPTOR,
  AUTH_REQUEST,
  AUTH_ERROR,
  AUTH_SUCCESS,
  AUTH_LOGOUT,
  PROFILE_REQUEST,

  SHOW_SPINNER,
  HIDE_SPINNER,
  SNACK_MESSAGE
} from "../actions";
import Axios from "axios";

const state = {
  hasToken: localStorage.getItem("user-token") || false,
  hasLoadedOnce: false
};

const getters = {
  isAuthenticated: state => !!state.hasToken,
};

const attachUserToken = () => {
  let str = localStorage.getItem('user-token');
  if (str && str !== undefined) {
    let tokens = JSON.parse(str);
    window.axios.defaults.headers.common['Authorization'] = `${tokens.token_type} ${tokens.access_token}`;
  }
};

const authErrorHandler = (commit, dispatch, err) => {
  dispatch(HIDE_SPINNER);
  commit(AUTH_ERROR, err);
  localStorage.removeItem("user-token");
  console.log('removeItem token 2');
};

const actions = {
  [AUTH_REQUEST]: ({
    commit,
    dispatch
  }, user) => {
    // user: username, password
    return new Promise((resolve, reject) => {
      dispatch(SHOW_SPINNER, 'Sign you in...');
      axios.post("/api/v1/admin/oauth2/token", user)
        .then(response => {
          dispatch(HIDE_SPINNER);
          if (response.code == 200) {
            localStorage.setItem("user-token", JSON.stringify(response.data));
            attachUserToken();
            commit(AUTH_SUCCESS);
            dispatch(PROFILE_REQUEST);
            resolve(response);
          } else {
            let err = new Error(response.data.data.message);
            authErrorHandler(commit, dispatch, err);
            reject(err);
          }
        })
        .catch(err => {
          authErrorHandler(commit, dispatch, err);
          reject(err);
        });
    });
  },
  [AUTH_LOGOUT]: ({
    commit
  }) => {
    return new Promise(resolve => {
      commit(AUTH_LOGOUT);
      console.log('removeItem token 1');
      localStorage.removeItem("user-token");
      resolve();
    });
  },

  [AXIOS_AUTH_INTERCEPTOR]: ({
    commit,
    dispatch
  }, route) => {
    attachUserToken();

    window.axios.interceptors.response.use(response => {
      let data = response.data;
      if (data.code == 401) {
        if (route.path !== "/admin/login") {
          route.push("/admin/login");
        }
        return Promise.reject(data.message ? data.message : data.data.message);
      }
      return data;
    }, error => {
      if (error.response.status === 401) {
        if (route.path !== "/admin/login") {
          route.push("/admin/login");
        }
      }
      return Promise.reject(error);
    });
  }
};

const mutations = {
  [AUTH_SUCCESS]: state => {
    state.hasToken = true;
    state.hasLoadedOnce = true;
  },
  [AUTH_ERROR]: state => {
    state.hasLoadedOnce = true;
  },
  [AUTH_LOGOUT]: state => {
    state.hasToken = false;
  }
};

export default {
  state,
  getters,
  actions,
  mutations
};