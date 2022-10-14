import { createStore } from "vuex";
import authStore from "./auth";
import messagesStore from "./messages";
import registryStore from "./registry";

export default createStore({
  modules: {
    auth: authStore,
    messages: messagesStore,
    registry: registryStore,
  },
  state: {
    hideConfigButton: false,
    isPinned: true,
    showConfig: false,
    sidebarType: "bg-gradient-dark",
    isRTL: false,
    color: "success",
    isNavFixed: false,
    isAbsolute: false,
    showNavs: true,
    showSidenav: true,
    showNavbar: true,
    showFooter: true,
    showMain: true,
    isDarkMode: false,
    navbarFixed:
      "position-sticky blur shadow-blur left-auto top-1 z-index-sticky px-0 mx-4",
    absolute: "position-absolute px-4 mx-0 w-100 z-index-2",
  },
  mutations: {
    toggleConfigurator(state) {
      state.showConfig = !state.showConfig;
    },
    navbarMinimize(state) {
      const sidenav_show = document.querySelector(".g-sidenav-show");

      if (sidenav_show.classList.contains("g-sidenav-pinned")) {
        sidenav_show.classList.remove("g-sidenav-pinned");
        state.isPinned = true;
      } else {
        sidenav_show.classList.add("g-sidenav-pinned");
        state.isPinned = false;
      }
    },
    navbarFixed(state) {
      if (state.isNavFixed === false) {
        state.isNavFixed = true;
      } else {
        state.isNavFixed = false;
      }
    },
    toggleEveryDisplay(state) {
      state.showNavbar = !state.showNavbar;
      state.showSidenav = !state.showSidenav;
      state.showFooter = !state.showFooter;
    },
    toggleHideConfig(state) {
      state.hideConfigButton = !state.hideConfigButton;
    },
    color(state, payload) {
      state.color = payload;
    },
  },
  actions: {
    setColor({ commit }, payload) {
      commit("color", payload);
    },
    async init({ state, dispatch }) {
      state.isTransparent = "bg-transparent";
      state.isDarkMode = false;
      state.color = "primary";
      await dispatch('auth/init', {}, {root: true});
      await dispatch('registry/init', {}, {root: true});
    },
  },
  getters: {},
});
