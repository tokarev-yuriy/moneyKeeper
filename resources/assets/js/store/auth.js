import { stateService } from "../api/auth";

export default {
  namespaced: true,
  state: {
    isLoggedIn: false,
    user: null
  },
  mutations: {
    isLoggedIn(state, payload) {
      state.isLoggedIn = payload;
    },
    user(state, payload) {
      state.user = payload;
    },
  },
  actions: {
    async init({ commit }) {
      try {
        let authState = await stateService();
        commit("user", authState.user);
        commit("isLoggedIn", authState.isLoggedIn);
      } catch (error) {
        throw error;
      };
    },
  },
  getters: {
    getUser: (state) => {
      return state.user;
    },
    isLoggedIn: (state) => {
      return state.isLoggedIn;
    }
  },
};
