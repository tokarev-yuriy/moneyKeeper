<!--
=========================================================
* Vue Material Dashboard 2 - v3.0.0
=========================================================

* Product Page: https://creative-tim.com/product/vue-material-dashboard-2
* Copyright 2022 Creative Tim (https://www.creative-tim.com)

Coded by www.creative-tim.com

 =========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<template>
  <sidenav
    :custom_class="color"
    :class="'fixed-start'"
  />
  <main
    class="main-content position-relative max-height-vh-100 h-100 overflow-x-hidden"
  >
    <!-- nav -->
    <router-view />
    <app-footer/>
  </main>
</template>
<script>
import Sidenav from "./layout/Sidenav";
import AppFooter from "./layout/Footer.vue";
import { mapMutations, mapState } from "vuex";
import { activateDarkMode } from "./md2/assets/js/dark-mode";

export default {
  name: "App",
  components: {
    Sidenav,
    AppFooter
  },
  computed: {
    ...mapState([
      "color",
    ])
  },
  beforeMount() {
    this.$store.state.isTransparent = "bg-transparent";

    const sidenav = document.getElementsByClassName("g-sidenav-show")[0];

    if (window.innerWidth > 1200) {
      sidenav.classList.add("g-sidenav-pinned");
    }
    this.$store.state.isDarkMode = true;
    this.$store.state.color = "primary";
    activateDarkMode();
  }
};
</script>
