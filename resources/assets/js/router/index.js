import { createRouter, createWebHistory } from "vue-router";
import Login from "../pages/Login.vue";
import Logout from "../pages/Logout.vue";
import Register from "../pages/Register.vue";
import Dashboard from "../pages/Dashboard.vue";
import AccountGroupIndex from "../pages/AccountGroup/Index.vue";
import AccountGroupEdit from "../pages/AccountGroup/Edit.vue";
import AccountGroupDelete from "../pages/AccountGroup/Delete.vue";
import AccountIndex from "../pages/Account/Index.vue";
import AccountEdit from "../pages/Account/Edit.vue";
import AccountDelete from "../pages/Account/Delete.vue";


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
  },
  {
    path: "/account/groups",
    name: "AccountGroupIndex",
    component: AccountGroupIndex
  },
  {
    path: "/account/groups/:id/delete",
    name: "AccountGroupDelete",
    component: AccountGroupDelete
  },
  {
    path: "/account/groups/:id",
    name: "AccountGroupEdit",
    component: AccountGroupEdit
  },
  {
    path: "/accounts",
    name: "AccountIndex",
    component: AccountIndex
  },
  {
    path: "/accounts/:id/delete",
    name: "AccountDelete",
    component: AccountDelete
  },
  {
    path: "/accounts/:id",
    name: "AccountEdit",
    component: AccountEdit
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
  linkActiveClass: "active",
});

export default router;
