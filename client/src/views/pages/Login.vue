<!-- =========================================================================================
	File Name: Login.vue
	Description: Login Page
	----------------------------------------------------------------------------------------
	Item Name: Vuesax Admin - VueJS Dashboard Admin Template
	Version: 1.1
	Author: Pixinvent
	Author URL: hhttp://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
	<div class="h-screen flex w-full bg-img">
		<div class="vx-col sm:w-1/2 md:w-1/2 lg:w-3/4 xl:w-3/5 mx-auto self-center">
			<vx-card>
				<div slot="no-body" class="full-page-bg-color">
					<div class="vx-row">
						<div class="vx-col hidden sm:hidden md:hidden lg:block lg:w-1/2 mx-auto self-center">
							<img src="@/assets/images/pages/login.png" alt="login" class="mx-auto">							
						</div>
						<div class="vx-col sm:w-full md:w-full lg:w-1/2 mx-auto self-center bg-white">
							<div class="p-8">
								<div class="vx-card__title mb-8">
									<h4 class="mb-4">Login</h4>
									<p>Welcome back, please login to your account.</p>
								</div>
								<vs-input icon="icon icon-user" icon-pack="feather" label-placeholder="Username" v-model="email" class="w-full mb-6 no-icon-border"/>
								<vs-input type="password" icon="icon icon-lock" icon-pack="feather" label-placeholder="Password" v-model="password" class="w-full mb-4 no-icon-border" />
								<div class="flex flex-wrap justify-between my-5">
									<vs-checkbox v-model="rememberMe" class="mb-3">Remember Me</vs-checkbox>
									<router-link to="/pages/forgot-password">Forgot Password?</router-link>
								</div>
								<vs-button class="float-right" @click.prevent="login()">Login</vs-button>
                <br/><br/>
							</div>
						</div>
					</div>
				</div>
			</vx-card>
		</div>
	</div>
</template>

<script>

import { mapGetters } from 'vuex'
// import Cookies from 'js-cookie'
export default {
	data() {
		return {
			email: '',
			password: '',
      rememberMe: false,
      error: ''
		}
  },
  created () {
    this.checkCurrentLogin()
  },
  updated () {
    this.checkCurrentLogin()
  },
  computed: {
    ...mapGetters({ currentUser: 'currentUser' })
  },
  methods: {
    checkCurrentLogin () {
      if (this.currentUser) {
        this.$router.replace(this.$route.query.redirect || '/')
      }
    },
    login () {
      this.axios.post('/site/login', { LoginForm: {email: this.email, password: this.password, rememberMe: this.rememberMe }})
        .then(request => { 
          this.loginSuccessful(request)
        })
        .catch((err) => {
          console.log(err) 
          this.loginFailed()
        })
    },
    loginSuccessful (req) {
      if (!req.data.token) {

        this.loginFailed(req.data.error)
        return
      }
      this.error = false
      this.$store.dispatch('login')

      this.$router.replace(this.$route.query.redirect || '/contacts')
    },
    loginFailed (error) {
      this.error = error || 'Login failed!'
      this.$vs.notify({
          title:'Login failed',
          text: this.error,
          color:'danger',
          position:'bottom-center'})
      this.$store.dispatch('logout')
    }
    // ...
  }
}
</script>