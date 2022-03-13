import Vue from 'vue'
import VueAxios from 'vue-axios'
import Cookies from 'js-cookie'
import axios from './axios'
// Vue Router
import router from '../router'
// Vuex Store
import store from '../store/store'

// Configure axios defaults (https://github.com/axios/axios#global-axios-defaults)

// Add a request interceptor
axios.interceptors.request.use(function (config) {
  // Do something before request is sent
  
  config.headers['Authorization'] = 'Bearer ' + Cookies.get('auth_token')
  return config;
}, function (error) {
  // Do something with request error
  return Promise.reject(error);
});

// Add a response interceptor
axios.interceptors.response.use(function (response) {
  // Do something with response data
  console.log("Response: ", response)
  if (response.data.token){
    Cookies.set('auth_token', response.data.token)
  }
  return response;
}, function (error) {
  // Do something with response error
  if (error.response.status == 401){
    store.dispatch('logout')
    router.push('/pages/login')
  }
  return Promise.reject(error);
});


Vue.use(VueAxios, axios)

export default axios
