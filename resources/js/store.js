/*
    Imports Vue and Vuex
*/
import Vue from 'vue'
import Vuex from 'vuex'

/*
    Initializes Vuex on Vue.
*/
Vue.use( Vuex )

/*
    Imports all of the modules used in the application to build the data store.
*/

import { users } from '@/js/modules/users.js'

/*
  Exports our data store.
*/
export default new Vuex.Store({
    modules: {
      users
    }
});
