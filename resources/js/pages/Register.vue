<template>
  <div class="py-4 flex-initial max-w-sm mx-auto">
    <form method="POST" @submit.prevent="handleSubmit()" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
          Name
        </label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              id="name" type="text" placeholder="John Doe" v-model="name" required autofocus>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
          Email
        </label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              id="email" type="email" placeholder="name@example.com" v-model="email" required>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
          Password
        </label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
            id="password" type="password" placeholder="Password" v-model="password" required>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="password-confirm">
          Confirm Password
        </label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
        id="password-confirm" type="password" placeholder="Password" v-model="password_confirmation" required>
      </div>
      <div class="flex items-center justify-start">
        <input id="not-admin" type="radio" class="mr-2 rounded focus:outline-none focus:shadow-outline" :checked="!isAdmin" @input="isAdmin = !isAdmin">
        <label for="not-admin" class="block text-gray-700 font-bold">Joining a family?</label>
      </div>
      <div class="mb-4 flex items-center justify-start">
        <input id="is-admin" type="radio" class="mr-2 rounded focus:outline-none focus:shadow-outline" :checked="isAdmin" @input="isAdmin = !isAdmin">
        <label for="is-admin" class="block text-gray-700 font-bold">Creating a new family?</label>
      </div>
      <div v-if="isAdmin" class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="family-name">
          Family Name
        </label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
         id="family-name" type="text" placeholder="Family Name" v-model="familyName" required>
      </div>
      <div class="text-center">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
          Register
        </button>
      </div>
    </form>
    <p class="text-center text-gray-500 text-xs">
      &copy;2020 Project Hermes. All rights reserved.
    </p>
  </div>
</template>

<script>
  export default {
    data(){
      return {
        name : "",
        email : "",
        password : "",
        password_confirmation : "",
        isAdmin: false,
        familyName: "",
      }
    },
    methods : {
      handleSubmit() {
        if(this.password.length > 0 && this.password === this.password_confirmation) {
          axios.post('api/register', {
            name: this.name,
            email: this.email,
            password: this.password,
            password_confirmation : this.password_confirmation,
            family_name: this.isAdmin ? this.familyName : "",
          }).then(res => {
            axios.get('/sanctum/csrf-cookie').then(res => {
              this.$router.push({ name: 'dashboard' });
            });
          })
          .catch(err => {
            console.log(err);
          });
        } else {
          this.password = "";
          this.passwordConfirm = "";
          return alert('Passwords do not match');
        }
      }
    }
  }
</script>
