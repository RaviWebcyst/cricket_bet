import Vue from 'vue';
import Router from 'vue-router';

import match from './components/pages/match.vue';
import home from './components/pages/home.vue';
import register from './components/pages/Register.vue';
import login from './components/pages/Login.vue';

Vue.use(Router);

const routes = [
    {
        path:'/match',
        component:match,
        name:"match"
    },
    {
        path:'/home',
        component:home,
        name:"Home"
    },
    {
        path:'/register',
        component:register,
        name:"Register"
    },
    {
        path:'/login',
        component:login,
        name:"Login"
    },
];

const router = new Router({
    mode:'history',
    routes
});

export default router;

