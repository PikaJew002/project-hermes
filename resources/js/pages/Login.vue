<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card card-default">
          <div class="card-header">Login</div>
          <div class="card-body">
            <form method="POST" @submit.prevent="handleSubmit()">
            <div class="form-group row">
              <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>
              <div class="col-md-6">
                <input id="email" type="email" class="form-control" v-model="email" required autofocus>
              </div>
            </div>
            <div class="form-group row">
              <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
              <div class="col-md-6">
                <input id="password" type="password" class="form-control" v-model="password" required>
              </div>
            </div>
            <div class="form-group row mb-0">
              <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                  Login
                </button>
              </div>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import UserAPI from '@/js/api/user';
  export default {
    data(){
      return {
        email : "",
        password : ""
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
