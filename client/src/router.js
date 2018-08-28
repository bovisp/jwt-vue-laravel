import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'home',
      component: () => import(/* webpackChunkName: "register" */ './views/Home.vue'),
    },
    {
        path: '/register',
        name: 'register',
        component: () => import(/* webpackChunkName: "register" */ './views/auth/Register.vue'),
        meta: {
            auth: false
        }
    },
    {
        path: '/login',
        name: 'login',
        component: () => import(/* webpackChunkName: "login" */ './views/auth/Login.vue'),
        meta: {
            auth: false
        }
    },
    {
        path: '/forgotpassword',
        name: 'forgotpassword',
        component: () => import(/* webpackChunkName: "forgotpassword" */ './views/auth/ForgotPassword.vue'),
        meta: {
            auth: false
        }
    },
    {
        path: '/reset/:token',
        name: 'reset',
        component: () => import(/* webpackChunkName: "reset" */ './views/auth/ResetPassword.vue'),
        meta: {
            auth: false
        }
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: () => import(/* webpackChunkName: "dashboard" */ './views/Dashboard.vue'),
        meta: {
            auth: true
        }
    },
    {
        path: '/admin',
        name: 'admin',
        component: () => import(/* webpackChunkName: "admin" */ './views/admin/Index.vue'),
        meta: {
            auth: {
                roles: 'admin',
                redirect: {name: 'login'},
                forbiddenRedirect: '/403'
            }
        }
    },
    {
        path: '/403',
        name: '403',
        component: () => import(/* webpackChunkName: "admin" */ './views/errors/403.vue')
    },
    {
        path: '/404',
        name: '404',
        component: () => import(/* webpackChunkName: "admin" */ './views/errors/404.vue')
    }
  ]
})
