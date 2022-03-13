<template>
  <div>
    <vs-row>

      <vs-card>

        <form-user
          ref="formUser"
          :id="Number(id)"
        ></form-user>
        <div slot="footer">
          <vs-row vs-justify="flex-end">
            <vs-button
              color="primary"
              type="border"
              @click="$router.push('/users')"
            >Back</vs-button>
            <vs-button
              color="primary"
              type="gradient"
              @click="updateUser()"
              :disabled="saving"
            >Save</vs-button>
          </vs-row>
        </div>
      </vs-card>

    </vs-row>
  </div>
</template>
<script>
import FormUser from './FormUser'
export default {
  components: { FormUser },
  data () {
    return {
      id: this.$route.params.id,
      saving: false,
    }
  },
  mounted () {
    this.id = this.$route.params.id
    this.$emit('changeRouteTitle', this.$route.meta.pageTitle + ' ' + this.id);
  },
  methods: {
    updateUser () {
      this.saving = true
      this.axios.post('/users/update?id=' + this.id, {
        User: this.$refs.formUser.user,
      })
        .then((res) => {
          console.log(res.data)
          if (res.data.success) {
            this.$router.push('/users')
            return
          }
          if (res.data.error) {
            this.$refs.formUser.error = true
            this.$refs.formUser.errorMessage = res.data.error
          }
          if (res.data.userErrors) {
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

