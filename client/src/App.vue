<!-- =========================================================================================
	File Name: App.vue
	Description: Main vue file - APP
	----------------------------------------------------------------------------------------
	Item Name: Vuesax Admin - VueJS Dashboard Admin Template
	Version: 1.1
	Author: Pixinvent
	Author URL: hhttp://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
	<div id="app">
		<router-view></router-view>
	</div>
</template>

<script>
import themeConfig from '@/../themeConfig.js'
import { mapGetters } from 'vuex'

export default {
    watch: {
        '$store.state.theme'(val) {
            this.toggleClassInBody(val);
        }
    },
    methods: {
        toggleClassInBody(className) {
            if (className == 'dark') {
                if (document.body.className.match('theme-semi-dark')) document.body.classList.remove('theme-semi-dark');
                document.body.classList.add('theme-dark');
            } else if (className == 'semi-dark') {
                if (document.body.className.match('theme-dark')) document.body.classList.remove('theme-dark');
                document.body.classList.add('theme-semi-dark');
            } else {
                if (document.body.className.match('theme-dark')) document.body.classList.remove('theme-dark');
                if (document.body.className.match('theme-semi-dark')) document.body.classList.remove('theme-semi-dark');
            }
        },
        checkCurrentUser(){
          if (!this.currentUser && this.$route.path !== '/pages/login' && this.$route.path !== '/pages/logout') {
            this.$router.push('/pages/login?redirect=' + this.$route.path)
          }
        },
    },
    mounted() {
      this.checkCurrentUser()
      this.toggleClassInBody(themeConfig.theme)
    },
    updated() {
      this.checkCurrentUser()
    },
    computed: {
      ...mapGetters({ currentUser: 'currentUser' })
    },
}
</script>