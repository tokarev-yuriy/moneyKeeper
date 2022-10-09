import { createRouter, createWebHistory } from "vue-router";
import Login from "../pages/Login.vue";
import Logout from "../pages/Logout.vue";
import Register from "../pages/Register.vue";
import Dashboard from "../pages/Dashboard.vue";


const routes = [
  {
    path: "/auth/login",
    name: "Login",
    component: Login,
  },
  {
    path: "/auth/logout",
    name: "Logout",
    component: Logout,
  },
  {
    path: "/auth/register",
    name: "Register",
    component: Register,
  },
  {
    path: "/",
    name: "Dashboard",
    component: Dashboard
  }
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
  linkActiveClass: "active",
});

export default router;
