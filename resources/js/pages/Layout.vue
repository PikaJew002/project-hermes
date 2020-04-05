<template>
  <div>
    <header class="bg-gray-700 sm:flex sm:justify-between sm:items-center sm:px-4 sm:py-3">
      <div class="flex items-center justify-between px-4 py-3 sm:p-0">
        <div>
          <router-link :to="{ name: 'home' }"><h1 class="font-bold text-2xl text-gray-300">Project Hermes</h1></router-link>
        </div>
        <div class="sm:hidden">
          <button @click="isOpen = !isOpen" type="button" class="block text-gray-500 hover:text-white focus:text-white focus:outline-none">
            <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
              <path v-if="isOpen" fill-rule="evenodd" d="M18.278 16.864a1 1 0 0 1-1.414 1.414l-4.829-4.828-4.828 4.828a1 1 0 0 1-1.414-1.414l4.828-4.829-4.828-4.828a1 1 0 0 1 1.414-1.414l4.829 4.828 4.828-4.828a1 1 0 1 1 1.414 1.414l-4.828 4.829 4.828 4.828z"/>
              <path v-if="!isOpen" fill-rule="evenodd" d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"/>
            </svg>
          </button>
        </div>
      </div>
      <nav :class="isOpen ? 'block' : 'hidden'" class="px-2 pt-2 pb-4 sm:flex sm:p-0">
        <!-- Authentication Links -->
        <router-link :to="{ name: 'login' }" class="block px-2 py-1 text-white font-semibold rounded hover:bg-gray-800" v-if="!loggedIn">Login</router-link>
        <router-link :to="{ name: 'register' }" class="mt-1 block px-2 py-1 text-white font-semibold rounded hover:bg-gray-800 sm:mt-0 sm:ml-2" v-if="!loggedIn">Register</router-link>
        <a class="mt-1 block px-2 py-1 text-white font-semibold rounded hover:bg-gray-800 sm:mt-0 sm:ml-2" v-if="loggedIn"> Hi, {{ user.name }}</a>
        <router-link :to="{ name: 'dashboard' }" class="mt-1 block px-2 py-1 text-white font-semibold rounded hover:bg-gray-800 sm:mt-0 sm:ml-2" v-if="loggedIn">Board</router-link>
        <a class="mt-1 block px-2 py-1 text-white font-semibold rounded hover:bg-gray-800 sm:mt-0 sm:ml-2" v-if="loggedIn" @click="logout"> Logout</a>
      </nav>
    </header>
    <main class="py-4">
      <router-view></router-view>
    </main>
  </div>
</template>
<script>
  import UserAPI from '@/js/api/user';
  export default {
    data(){
      return {
        isOpen: false,
      }
    },
    methods: {
      logout() {
        UserAPI.logout().then(res => {
          this.$store.dispatch('loadUser');
        }).catch(err => {

        });
      }
    },
    created(){

    },
    computed: {
      user() {
        return this.$store.getters.getUser;
      },
      loggedIn() {
        if(this.user) {
          return this.user.hasOwnProperty('id');
        } else {
          return false;
        }
      }
    }
  }
</script>
