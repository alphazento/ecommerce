/* eslint-disable promise/param-names */
import {
  SHOW_SPINNER,
  HIDE_SPINNER,
  SNACK_MESSAGE
} from "../actions";

const state = {
  spinnerOverlay: {
    absolute: false,
    opacity: 0.76,
    overlay: false,
    text: "",
    snack: false
  }
};

const getters = {};

const actions = {
  [SHOW_SPINNER]: ({
    commit
  }, text) => {
    commit('controlSpinnerLayer', {
      overlay: true,
      snack: false,
      text: text
    });
  },
  [HIDE_SPINNER]: ({
    commit
  }) => {
    commit('controlSpinnerLayer', {
      overlay: false
    });
  },
  [SNACK_MESSAGE]: ({
    commit
  }, text) => {
    commit('controlSpinnerLayer', {
      overlay: false,
      snack: true,
      text: text
    });
  }
};

const mutations = {
  controlSpinnerLayer: (state, newValues) => {
    Object.assign(state.spinnerOverlay, newValues);
  }
};

export default {
  state,
  getters,
  actions,
  mutations
};