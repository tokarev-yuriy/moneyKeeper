export default {
  namespaced: true,
  state: {
    messages: []
  },
  mutations: {
    addMessage(state, payload) {
      state.messages.push(payload);
    },
    cleanMessage(state) {
      state.messages = [];
    }
  },
  actions: {
    clean({ commit }) {
      commit("cleanMessage");
    },
    add: ({ commit }, message) => {
      commit("addMessage", message);
    }
  },
  getters: {
    get: (state) => {
      return state.messages;
    }
  },
};
