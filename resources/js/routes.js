import Vue from 'vue';
import VueRouter from 'vue-router';
import store from '@/js/store.js';
import Layout from '@/js/pages/Layout';
import Login from '@/js/pages/Login';
import Register from '@/js/pages/Register';
import Dashboard from '@/js/pages/Dashboard';
import Home from '@/js/pages/Home';

Vue.use(VueRouter);

function requireAuth(to, from, next) {
  function proceed() {
    if(store.getters.getUserLoadStatus() == 2) {
      next();
    } else {
      next('/');
    }
  }
  if(store.getters.getUserLoadStatus() != 2) {
    store.dispatch('loadUser');
    store.watch(store.getters.getUserLoadStatus, function() {
      if(store.getters.getUserLoadStatus() == 2 || store.getters.getUserLoadStatus() == 3) {
        return proceed();
      }
    });
  } else {
    proceed();
  }
}

function noAuth(to, from, next) {
  function proceed() {
    if(store.getters.getUserLoadStatus() == 3) {
      next();
    } else {
      next('/dashboard');
    }
  }
  if(store.getters.getUserLoadStatus() != 3) {
    store.dispatch('loadUser');
    store.watch(store.getters.getUserLoadStatus, function() {
      if(store.getters.getUserLoadStatus() == 2 || store.getters.getUserLoadStatus() == 3) {
        return proceed();
      }
    });
  } else {
    proceed();
  }
}

export default new VueRouter({
  routes: [
    {
      path: '/',
      redirect: { name: 'home' },
      name: 'layout',
      component: Layout,
      children: [
        {
          path: 'home',
          name: 'home',
          component: Home
        },
        {
          path: 'login',
          name: 'login',
          component: Login,
          beforeEnter: noAuth
        },
        {
          path: 'register',
          name: 'register',
          component: Register,
          beforeEnter: noAuth
        },
        {
          path: 'dashboard',
          name: 'dashboard',
          component: Dashboard,
          beforeEnter: requireAuth
        }
      ]
    }
  ]
});
