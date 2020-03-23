import Vue from 'vue'
import App from './App.vue'

import Vuex from 'vuex'
import Axios from 'axios'
import VueRouter from 'vue-router'

Vue.config.productionTip = false;
Vue.prototype.$http = Axios;

Vue.use(Vuex);
Vue.use(VueRouter);

import router from "@/router";
import store from "@/store/store";

const token = localStorage.getItem('token');

if (token) {
  Vue.prototype.$http.defaults.headers.common['Authorization'] = token;
}

new Vue({
  render: h => h(App),
  router,
  store,
}).$mount('#app');
