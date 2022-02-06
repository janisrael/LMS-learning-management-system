/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import store from './store'
import Vue from 'vue';
import App from './App.vue'
import Vuex from 'vuex'

import ElementUI from 'element-ui'
import '../../resources/styles/theme.css';
import '../../resources/styles/new_theme.css';
import 'element-ui/lib/theme-chalk/index.css';
import locale from 'element-ui/lib/locale/lang/en' // lang i18n
import IdleVue from 'idle-vue'
require('./bootstrap');

// DataTables
require('datatables.net/js/jquery.dataTables.min.js');
require('datatables.net-bs4/js/dataTables.bootstrap4.min.js');
require('datatables.net-responsive/js/dataTables.responsive.min.js');
require('datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js');

// Date range picket
window.moment = require('moment');
window.moment.locale('en');
require('daterangepicker');

// App Theme
require('admin-lte');

window.Vue = require('vue');

//Import Vue Filter
require('./filter');

//Import progressbar
require('./progressbar');

//Setup custom events
require('./customEvents');

const eventsHub = new Vue()

//Import View Router
import VueRouter from 'vue-router'
Vue.use(VueRouter)

//Import Sweetalert2
import Swal from 'sweetalert2'


window.Swal = Swal
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})
window.Toast = Toast

//Import v-from
import { Form, HasError, AlertError } from 'vform'
window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

import vueCountryRegionSelect from 'vue-country-region-select'
Vue.use(vueCountryRegionSelect)

import VueCountryCode from "vue-country-code-select";
Vue.use(VueCountryCode);

//Routes
import { routes } from './router/index';
Vue.prototype.$routers = routes

// global variables for frontend payments
Vue.prototype.$customerType = ""
Vue.prototype.$globCurrencyValue = "USD"
// ---------------- //
// import { allCountries } from './components/admin/FrontEndPayments/Modals/country';
// Vue.prototype.$allCountries = allCountries

// window.Chargebee.init({
//     site:  window.ENV.SC_ADMIN_CHARGEBEE_SITE,
//     publishableKey: window.ENV.SC_ADMIN_CHARGEBEE_KEY
// })

//Register Routes
const router = new VueRouter({
    routes,
    mode: 'hash',
})

// console.log((+timeParts[0] * (60000 * 60)) + (+timeParts[1] * 60000));
var timeparts = window.ENV.SESSION_TIMEOUT
var to_sec = timeparts * 60000
var session = to_sec
Vue.use(ElementUI, { locale })
Vue.use(IdleVue, {
    eventEmitter: eventsHub,
    store: store,
    idleTime: session,
    startAtIdle: false

})


const app = new Vue({
    render: h => h(App),
    store: store,
    router,
  }).$mount('#app')

// new Vue({
//     render: h => h(App),
//   }).$mount('#app')
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app',
// });
