import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)


export const storeUser = new Vuex.Store({
    state:{
        token: localStorage.getItem("auth"),
        showView: false

    },
    mutations: {
        setToken(state,token){
            localStorage.setItem("auth", token);
            state.token = token;
        },
        clearToken(state){
            localStorage.removeItem("auth");
            state.token ="";
        },
        showSideTop(state, option){
            state.showView = option;
        }

    },

})
