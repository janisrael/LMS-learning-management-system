/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import store from './store'
import Vue from 'vue';
import '../../resources/styles/theme.css';
import '../../resources/styles/lms_theme.css';
import 'bootstrap/dist/css/bootstrap.css'
import 'element-ui/lib/theme-chalk/index.css';
import locale from 'element-ui/lib/locale/lang/en' // lang i18n
import VuePageTransition from 'vue-page-transition'
import Vuex from 'vuex'
import axios from 'axios'

import VueRouter from 'vue-router'
import VueProgressBar from 'vue-progressbar'
import { routes } from './router/index';
import ElementUI from 'element-ui'
require('./bootstrap');
require('admin-lte');

const options = {
  color: '#bffaf3',
  failedColor: '#874b4b',
  thickness: '5px',
  transition: {
    speed: '0.2s',
    opacity: '0.6s',
    termination: 300
  },
  autoRevert: true,
  location: 'left',
  inverse: false
}

Vue.use(Vuex)
Vue.use(ElementUI, { locale })
Vue.use(VueProgressBar, options)
Vue.use(VuePageTransition)
window.Vue = require('vue');

Vue.use(VueRouter)
Vue.use(ElementUI, { locale })
Vue.prototype.$routers = routes
const router = new VueRouter({
  routes,
  mode: 'hash',
})

Vue.component('index-component', require('./components/Layout/Index.vue').default);

const app = new Vue({
    el: '#app',
    store: store,
    router
});
