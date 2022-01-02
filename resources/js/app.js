require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router';
import ViewUI from 'view-design';
import Common from './common';
import moment from "moment";
import store from './store';
import 'view-design/dist/styles/iview.css';
import Vuex from 'vuex';
import Swal from "sweetalert2";
import {storeUser} from './store/index'



Vue.use(ViewUI)
Vue.use(VueRouter)
Vue.mixin(Common)
Vue.use(moment)
Vue.use(Vuex)

// Vue.use(Swal)
window.Swal = Swal

// axios.defaults.baseURL= 'http://localhost:8000/api/'

// axios.defaults.withCredentials = true
// axios.defaults.baseURL= 'http://localhost:8000/api/'
// const token = localStorage.getItem('token')
// if(token){
//     axios.defaults.headers.common['Authorization'] = token
// }
//
// // manage error and expire token
//
// axios.interceptors.response.use(undefined, function (error) {
//     if (error) {
//         const originalRequest = error.config;
//         if (error.response.status === 401 && !originalRequest._retry) {
//             originalRequest._retry = true;
//             store.dispatch('logout')
//             return router.push('/login')
//         }
//         else{
//             store.commit('handle_error',JSON.parse(error.response.data.error));
//         }
//     }
// })
//








// Routes Import
import {routes} from './router'

const Router = new VueRouter({
    routes,
    mode: 'history'
})

Vue.filter('dateFormat', function (value){
    if (value){
        return moment(String(value)).format("MMM Do YY");
    }
})



Vue.component('app', require('./components/App.vue').default);

const app = new Vue({
    el: '#app',
    router:Router,
    store:storeUser,
});
