import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Home";
import Login from "../views/Login";
import Register from "../views/Register";

import auth from './middleware/auth';

Vue.use(VueRouter);

export default new VueRouter({
  mode: "history",
  routes: [
    { path: "/", name: 'home', component: Home, beforeEnter: auth },
    { path: "/login", name: "login", component: Login },
    { path: "/register", component: Register },
    { path: "*", redirect: "/" }
  ]
});