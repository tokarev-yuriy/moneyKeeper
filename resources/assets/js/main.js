import { createApp } from "vue";
import App from "./App.vue";
import store from "./store";
import router from "./router";
import "./md2/assets/css/nucleo-icons.css";
import "./md2/assets/css/nucleo-svg.css";
import MaterialDashboard from "./md2/material-dashboard";

const appInstance = createApp(App);
appInstance.use(store);
appInstance.use(router);
appInstance.use(MaterialDashboard);
appInstance.mount("#app");
