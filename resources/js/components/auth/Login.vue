<template>
  <div>
    <div class="container">
      <div class="row justify-content-center py-5">
        <div class="col-sm-5">
          <div class="card">
            <div class="card-body">
              <h3 class="text-center text-uppercase" v-if="setting">{{setting.title }}</h3>
              <div class="errors" v-if="message">
                <p class="text-center">{{message}}</p>
              </div>
              <p class="text-muted">Login</p>
              <form v-on:submit.prevent="login">
                <div class="form-group">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fa fa-user"></i>
                      </span>
                    </div>
                    <input name="email" type="email" v-model="email" class="form-control" placeholder="Email Address">
                  </div>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fa fa-lock"></i>
                      </span>
                    </div>
                    <input name="password" type="password" v-model="password" class="form-control" placeholder="Password">
                  </div>
                </div>
                <div class="input-group mb-4">
                  <div class="form-check checkbox">
                    <input class="form-check-input" name="remember" type="checkbox" id="remember" style="vertical-align: middle;" />
                    <label class="form-check-label" for="remember" style="vertical-align: middle;">
                      Remember Me
                    </label>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-12">
                    <button class="btn btn-primary login-btn">
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
  </div>
</template>


<script>
import {get, byMethod} from '../../lib/api'
import { mapGetters } from 'vuex';

export default{
  data(){
    return {
      email: '',
      password: '',
      method: 'POST',
      errors: {},
      message: ''
    }
  },
  async mounted(){
    this.$store.dispatch('getSetting')
  },
  methods:{
    // async login() {
    //   await byMethod(this.method, '/api/login',
    //     {
    //       email:this.email,
    //       password:this.password,
    //     })
    //     .then((res) => {
    //       localStorage.setItem('user-token', res.data.token)
    //       this.$store.dispatch('user', res.data.user)
    //       this.$router.push({name: 'dashboard'})
    //     })
    //     .catch((err) => {
    //         console.log(err)
    //     })
    // },
    login: function () {
      let email = this.email
      let password = this.password
      this.$store.dispatch('login', { email, password })
      .then(() => this.$router.push('/dashboard'))
      .catch(error => {
        if(error.response.status === 422) {
          this.errors = error.response.data.errors
          this.message = 'Both Email and password fields are required!'
        }
        if(error.response.status == 401){
          this.message = 'Warning! Username or Password Incorrect.'
        }
      })
    }
  },
  computed:{
    ...mapGetters(['setting'])
  }
}
</script>

<style lang="scss">
  .errors{
    color: #d70404;
  }
  .col-sm-5 {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    width: 600px;
  }

  .login-btn{
    display: block;
    margin-left: auto;
    margin-right: 0;
    width: 150px;
  }
</style>