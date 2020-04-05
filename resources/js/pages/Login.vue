<template>
  <div class="py-4 flex-initial max-w-sm mx-auto">
    <form method="POST" @submit.prevent="handleSubmit()" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
          Email
        </label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
         id="email" type="email" placeholder="Email" v-model="email" required>
      </div>
      <div class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
          Password
        </label>
        <input :class="{ 'border-red-500': isError }" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
        id="password" type="password" placeholder="Password" v-model="password" required>
        <p v-if="isError" class="text-red-500 text-xs italic">Please choose a password.</p>
      </div>
      <div class="flex items-center justify-between">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
          Sign In
        </button>
        <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">
          Forgot Password?
        </a>
      </div>
    </form>
    <p class="text-center text-gray-500 text-xs">
      &copy;2020 Project Hermes. All rights reserved.
    </p>
  </div>
</template>

<script>
  import UserAPI from '@/js/api/user';
  export default {
    data(){
      return {
        email : "",
        password : "",
        isError: false,
        isAdmin: false,
        family: {
          name: ""
        }
      }
    },
    methods : {
      handleSubmit() {
        if(this.password.length > 0) { // replace with validation -> vueildate
          axios.get('sanctum/csrf-cookie').then(response => {
            UserAPI.login({
              email: this.email,
              password: this.password
            }).then(res => {
              // Successful Login
              this.$router.push({ name: 'dashboard'});
            }).catch(err => {
              // Failed Login
              // Display some kinda error
            });
          });
        }
      }
    }
  }
</script>
