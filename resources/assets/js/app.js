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
    "profile-component",
    require("./components/ProfileComponent.vue")
);
Vue.component(
    "wallet-index-component",
    require("./components/Wallet/WalletIndexComponent")
);
Vue.component(
    "order-index-component",
    require("./components/Order/OrderIndexComponent")
);
Vue.component(
    "location-index-component",
    require("./components/Location/LocationIndexComponent")
);
Vue.component(
    "dashboard-component",
    require("./components/Dashboard/DashboardComponent")
);

import Lightbox from "vue-pure-lightbox";
import VueSession from 'vue-session'
Vue.use(VueSession);
Vue.use(Lightbox);
Vue.use(require("vue-moment"));

const app = new Vue({
    el: "#app",
    beforeMount() {
        if (typeof this.getCookie('token') !== 'undefined') {
            console.log('token set in local storage');
            localStorage.setItem('jwt-token', this.getCookie('token'));
            this.deleteCookie('token');
        }
    },
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
            var value = "; " + document.cookie;
            var parts = value.split("; " + name + "=");
            if (parts.length === 2) return parts.pop().split(";").shift();
        },
        deleteCookie( name ) {
            document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        }
    }
});
