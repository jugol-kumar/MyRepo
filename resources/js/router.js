import Dashboard from "./components/pages/Dashboard";


import Tags from './components/pages/tags/Tag'
import Category from './components/pages/category/Category'
import VueXCOm from './vuex/useCom'

import Adminusers from './components/pages/adminusers/AdminUser'


import Login from './components/login'
export const routes = [
    {
      path: '/',
      component: Dashboard
    },
    {
      path: '/tags',
      component: Tags
    },
    {
        path: '/categories',
        component: Category,
    },
    {
        path: '/adminusers',
        component: Adminusers,
    },
    {
        path: '/vuex-page',
        component: VueXCOm,
    },


    {
        path: '/login',
        component: Login,
    }



]
