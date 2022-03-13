<template>
  <div></div>
</template>

<script>
export default {
  created(){
    if (!this.$store.state.AppActiveUser.admin){
      this.$router.replace('/pages/error-403')
      return
    }
  }
}
</script>

