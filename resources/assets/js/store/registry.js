import { getRegistryService } from "../api/registry.js";

export default {
  namespaced: true,
  state: {
    icons: [],
    colors: []
  },
  mutations: {
    setIcons(state, payload) {
      state.icons = payload;
    },
    setColors(state, payload) {
      state.colors = payload;
    }
  },
  actions: {
    async init({ commit }) {
      try {
        let registry = await getRegistryService();
        commit('setIcons', registry.icons);
        commit('setColors', registry.colors);
      } catch (e) {
        console.log(e);
      }
    }
  },
  getters: {
    getIcons: (state) => {
      return state.icons;
    },
    getColors: (state) => {
      return state.colors;
    }
  },
};
