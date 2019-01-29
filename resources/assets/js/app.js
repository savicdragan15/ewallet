/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component(
  'menu-menu',
  require("./Menu")
);

import VueRouter from 'vue-router'
import Lightbox from "vue-pure-lightbox";
import OrderIndexComponent from "./components/Order/OrderIndexComponent";
import DashboardComponent from  "./components/Dashboard/DashboardComponent";
import ProfileComponent from  "./components/ProfileComponent";
import WalletIndexComponent from "./components/Wallet/WalletIndexComponent";
import CategoryComponent from "./components/Category/CategoryComponent";

window.Vue.use(Lightbox);
window.Vue.use(require("vue-moment"));
Vue.use(VueRouter)

const router = new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/home',
      name: 'dashboard',
      component: DashboardComponent
    },
    {
      path: '/profile',
      name: 'profile',
      component: ProfileComponent
    },
    {
      path: '/wallets',
      name: 'wallets',
      component: WalletIndexComponent
    },
    {
      path: '/categories',
      name: 'categories',
      component: CategoryComponent
    },
    {
      path: '/orders',
      name: 'orders',
      component: OrderIndexComponent
    },
    {
      path: '/orders?openModal=true',
      name: 'add-new-order',
      component: OrderIndexComponent
    },
    {
      path: '/wallets?openModal=true',
      name: 'add-new-wallet',
      component: WalletIndexComponent
    }
  ],
});

const app = new Vue({
  el: "#app",
  router,
  data() {
    return {
      apiUrl: "api/v1",
      currency: "RSD",
      userId: Laravel.user.id
    };
  },
  methods: {
    getUrlParam(key) {
      let url = new URL(window.location.href);
      return url.searchParams.get(key);
    },
    getCookie(name) {
      let value = "; " + document.cookie;
      let parts = value.split("; " + name + "=");
      if (parts.length === 2) return parts.pop().split(";").shift();
    }
  }
});
