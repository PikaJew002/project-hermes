<template>
  <div>
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
      <div class="container">
        <router-link :to="{name: 'home'}" class="navbar-brand">Project Hermes</router-link>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Left Side Of Navbar -->
          <ul class="navbar-nav mr-auto"></ul>
          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            <router-link :to="{ name: 'login' }" class="nav-link" v-if="!loggedIn">Login</router-link>
            <router-link :to="{ name: 'register' }" class="nav-link" v-if="!loggedIn">Register</router-link>
            <li class="nav-link" v-if="loggedIn"> Hi, {{ user.name }}</li>
            <router-link :to="{ name: 'dashboard' }" class="nav-link" v-if="loggedIn">Board</router-link>
            <a class="nav-link" v-if="loggedIn" @click="logout"> Logout</a>
          </ul>
        </div>
      </div>
    </nav>
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
