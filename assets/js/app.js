import Vue from 'vue';
import App from './components/App';
import router from "./router";
import BootstrapVue from 'bootstrap-vue';
import store from './store'
import axios from 'axios'
import VueAxios from 'vue-axios'
 

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(VueAxios, axios)
Vue.use(BootstrapVue);

const app = new Vue({
    el: '#app',
    store,
    router,
    template: '<app/>',
    components: { App }
});