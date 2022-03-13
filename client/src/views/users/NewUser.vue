<template>
  <div>
    <vs-row>
    
        <vs-card>
          
          <form-user ref="formUser"></form-user>
          <div slot="footer">
            <vs-row vs-justify="flex-end">
              <vs-button color="primary" type="border" @click="$router.push('/users')">Back</vs-button>
              &nbsp;
              <vs-button color="primary" type="gradient" @click="createUser()" :disabled="saving">Save</vs-button>
            </vs-row>
            <br/><br/>
          </div>
        </vs-card>

    </vs-row>
  </div>
</template>
<script>
import FormUser from './FormUser'
export default {
  components: {FormUser},
  data() {
    return {
      saving: false,
    }
  },
  methods: {
    createUser(){
      this.saving = true
      this.axios.post('/users/create', {
        User: this.$refs.formUser.user,
      })
      .then((res) => {
        console.log(res.data)
        if (res.data.success){
          this.$router.push('/users')
          return
        }
        if (res.data.error){
          this.$refs.formUser.error = true
          this.$refs.formUser.errorMessage = res.data.error
        }
        if (res.data.userErrors){
          this.$refs.formUser.userErrors = res.data.userErrors
        }
        
      })
      .finally(() => {
        this.saving = false
      })
    }
  }
}
</script>

