<template>
  <div class="pb-10 mb-2">
    <!--<vs-alert v-bind:active="error" color="danger" icon-pack="feather" icon="icon-info">
      <span v-html="errorMessage"></span>
    </vs-alert>-->
    <vs-divider position="left">User Data</vs-divider>
    <div class="vx-row">
      <div class="vx-col sm:w-1/3 w-full mb-2">
        <vs-input
          class="w-full"
          label-placeholder="User Email"
          v-model="$v.user.email.$model"
          :danger="validator.hasError('user.email', 'User Email')"
          :danger-text="validator.errorText('user.email', 'User Email')"
          val-icon-danger="clear"
          @keyup="userErrors.email = null"
        />
      </div>
    </div>
    <div class="vx-row">
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input
          class="w-full"
          label-placeholder="User Name"
          v-model="$v.user.name.$model"
          :danger="validator.hasError('user.name', 'User Name')"
          :danger-text="validator.errorText('user.name', 'User Name')"
          val-icon-danger="clear"
          @keyup="userErrors.name = null"
        />
      </div>
    </div>
    <vs-divider></vs-divider>
    <vs-divider position="left">User Management</vs-divider>
    <div class="vx-row">
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-input
          class="w-full"
          label-placeholder="Set/Reset Password"
          v-model="$v.user.password.$model"
          :danger="validator.hasError('user.password', 'User Password')"
          :danger-text="validator.errorText('user.password', 'User Password')"
          val-icon-danger="clear"
          @keyup="userErrors.password = null"
        />
      </div>
      <div class="vx-col sm:w-1/2 w-full mb-2">
        <vs-select
          label="Status"
          v-model="$v.user.status.$model"
          autocomplete
        >
          <vs-select-item
            :key="i"
            :value="item.value"
            :text="item.text"
            v-for="(item, i) in userStatusCodes"
          />
        </vs-select>
      </div>

    </div>
    <vs-divider></vs-divider>

  </div>
</template>
<script>
import { required, email } from 'vuelidate/lib/validators'
import Validator from '../../validation'
export default {

  data () {
    return {
      error: false,
      errorMessage: '',
      validator: new Validator(this),
      user: {
        email: '',
        name: '',
        password: '',
        status: '1'
      },
      userStatusCodes: [
        { text: 'Active', value: '1' },
        { text: 'Suspended', value: '0' },
      ],
      userErrors: {
        email: null,
        status: null
      },
    }
  },
  validations: {
    user: {
      email: { required, email },
      name: {},
      password: {},
      status: {}
    },
  },
  props: {
    id: {
      type: Number,
      default: null
    }
  },
  mounted () {
    if (this.id) {
      this.loadData()
    }
  },
  watch: {
    error (val) {
      if (val == true) {
        this.$vs.notify({
          title: 'Server Error',
          text: this.errorMessage,
          color: 'danger',
          position: 'bottom-center'        })
      }
    }
  },
  methods: {
    loadData () {
      const id = this.id
      this.axios.get('/users/user-data?id=' + id)
        .then((res) => {
          this.error = false
          this.errorMessage = ''
          if (res.data.error) {
            this.error = true
            this.errorMessage = res.data.error
          }
          if (res.data.user) {
            this.user = res.data.user
            this.user.password = ''
          }
        })
    }
  }
}
</script>
