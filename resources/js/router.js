import Dashboard from "./components/pages/Dashboard";
import Login from './components/login'
export const routes = [
    {
      path: '/',
      component: Dashboard
    },
    {
        path: '/login',
        component: Login,
    }
]
