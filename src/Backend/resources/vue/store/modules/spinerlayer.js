/* eslint-disable promise/param-names */
import {
  SHOW_SPINNER,
  HIDE_SPINNER,
  SNACK_MESSAGE,
  HIDE_SNACK
} from "../actions";

const state = {
  spinner_ctl: {
    absolute: false,
    opacity: 0.76,
    overlay: false,
    text: "",
    snack_bar: false
  }
};

const getters = {
  spinnerCtl: state => state.spinner_ctl
};

const actions = {
  [SHOW_SPINNER]: ({
    commit
  }, text) => {
    commit(SHOW_SPINNER, text);
  },
  [HIDE_SPINNER]: ({
    commit
  }) => {
    commit(HIDE_SPINNER);
  },

  [SNACK_MESSAGE]: ({
    commit
  }, text) => {
    commit(SNACK_MESSAGE, text);
  },
  [HIDE_SNACK]: ({
    commit
  }) => {
    commit(HIDE_SNACK);
  }
};

const mutations = {
  [SHOW_SPINNER]: (state, text) => {
    state.spinner_ctl.overlay = true;
    state.spinner_ctl.text = text;
  },

  [HIDE_SPINNER]: (state) => {
    state.spinner_ctl.overlay = false;
  },

  [SNACK_MESSAGE]: (state, text) => {
    state.spinner_ctl.overlay = false;
    state.spinner_ctl.text = text;
    state.spinner_ctl.snack_bar = true;
  },

  [HIDE_SNACK]: (state) => {
    state.spinner_ctl.snack_bar = false;
  }
};

export default {
  state,
  getters,
  actions,
  mutations
};