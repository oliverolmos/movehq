<template>
  <div>Login out...</div>
</template>

<script>
// import Cookies from 'js-cookie'
export default {
  name: 'Logout',
  created () {
    //Cookies.remove('auth_token')
    this.$store.dispatch('logout')
    this.$router.push('/pages/login')
  }
}
</script>