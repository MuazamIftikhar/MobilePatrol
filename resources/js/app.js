/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue';
import VueRouter from 'vue-router'
Vue.use(VueRouter);
require('./bootstrap');

window.Vue = require('vue').default;

axios.defaults.headers = {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
}
import { Datetime } from 'vue-datetime'
// You need a specific loader for CSS files
import 'vue-datetime/dist/vue-datetime.css'

Vue.component('datetime', Datetime);
Vue.use(require('vue-moment'));


import VueToast from 'vue-toast-notification';
// Import one of the available themes
//import 'vue-toast-notification/dist/theme-default.css';
import 'vue-toast-notification/dist/theme-sugar.css';

Vue.use(VueToast, {
    // One of options
    position: 'top'
});
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('schedule-component', require('./components/schedule/ScheduleComponent.vue').default);
Vue.component('form-component', require('./components/form/AddFormComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Axios URL
//axios.defaults.baseURL="http://127.0.0.1:8000/";
//Production AXios URL
 axios.defaults.baseURL="https://mobilepatrol.cybermeteorshosting.com/";
//Data Table

import { VuejsDatatableFactory} from 'vuejs-datatable';
import 'vuejs-datatable/dist/themes/bootstrap-4.esm'
Vue.use(VuejsDatatableFactory);

//Routes
const routes = [ ///
    { path: '/manager/schedule/',
        name:'manage-schedules',
        component: require('./components/schedule/MainComponent.vue').default
    },
    { path: '/manager/schedule/:id/:name',
        name:'schedule-tab',
        component: require('./components/schedule/ScheduleTabComponent.vue').default
    },
    { path: '/manager/form',
        name:'manager-add-form',
        component: require('./components/form/AddFormComponent.vue').default
    },
    { path: '/manager/form/edit/:id/:hash',
        name:'manager-edit-form',
        component: require('./components/form/EditFormComponent.vue').default
    },
];
const router = new VueRouter({
    mode: 'history',
    routes //passing routes in vueRouter
});
const app = new Vue({
    router, // replace routes with router

}).$mount("#app");
