/*=========================================================================================
  File Name: main.js
  Description: main vue(js) file
  ----------------------------------------------------------------------------------------
  Item Name: Vuesax Admin - VueJS Dashboard Admin Template
  Version: 1.1
  Author: Pixinvent
  Author URL: hhttp://www.themeforest.net/user/pixinvent
==========================================================================================*/


import Vue from 'vue'
import App from './App.vue'

// Use vue-axios
import axios from './axios'



// Vuesax Component Framework
import Vuesax from 'vuesax'
import 'material-icons/iconfont/material-icons.css' //Material Icons
import 'vuesax/dist/vuesax.css'; // Vuesax
Vue.use(Vuesax)

// Vuelidate Component global use
import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)

// Theme Configurations
import '../themeConfig.js'

// Globally Registered Components
import './globalComponents.js'

// Styles: SCSS
import './assets/scss/main.scss'

// Tailwind
import '@/assets/css/main.css';

// Vue Router
import router from './router'

// Vuex Store
import store from './store/store'



// PrismJS
import 'prismjs'
import 'prismjs/themes/prism.css'

// Feather font icon
require('./assets/css/iconfont.css')

Vue.config.productionTip = false

new Vue({
    router,
    store,
    axios,
    render: h => h(App)
}).$mount('#app')