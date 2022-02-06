/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import store from './store'
import Vue from 'vue';
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import VueRouter from 'vue-router'


// Import Bootstrap an BootstrapVue CSS files (order is important)
import '../../resources/styles/theme.css';
import '../../resources/styles/lms_theme.css';
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import locale from 'element-ui/lib/locale/lang/en' // lang i18n
// import Cookies from 'js-cookie'
import Vuex from 'vuex'
import { routes } from './router/index';
import axios from 'axios'
require('./bootstrap');
require('admin-lte');
Vue.use(Vuex)

Vue.prototype.$routers = routes

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
// Vue.use(Cookies)
Vue.use(VueRouter)
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(ElementUI, { locale })

const router = new VueRouter({
  routes,
  mode: 'hash',
})

Vue.component('index-component', require('./components/Layout/Index.vue').default);

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store: store,
    router
});
