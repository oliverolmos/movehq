<template>
  <div>
    <only-admin></only-admin>
    <vs-row>
      <vs-col :class="'text-right'">
        <vs-button
          color="success"
          type="border"
          @click="$router.push('/users/new')"
        >New User</vs-button>
      </vs-col>
    </vs-row>
    <vs-row>
      <vs-col>
        <vs-table
          search
          pagination
          max-items="10"
          :data="users"
        >
          <template slot="thead">
            <vs-th sort-key="id">Id</vs-th>
            <vs-th sort-key="name">Name</vs-th>
            <vs-th sort-key="email">Email</vs-th>
            <vs-th sort-key="status">Status</vs-th>
            <vs-th>Actions</vs-th>
          </template>

          <template slot-scope="{data}">
            <vs-tr
              :data="tr"
              :key="indextr"
              v-for="(tr, indextr) in data"
            >
              <vs-td :data="data[indextr].id">
                {{ tr.id }}
              </vs-td>
              <vs-td :data="data[indextr].name">
                {{ data[indextr].name }}
              </vs-td>
              <vs-td :data="data[indextr].email">
                {{ data[indextr].email }}
              </vs-td>
              <vs-td>
                <vs-chip :color="getStatusColor(data[indextr].status)">{{getStatusText(data[indextr].status)}}</vs-chip>
              </vs-td>
              <vs-td>
                <div class="flex">
                  <vs-button
                    type="border"
                    size="small"
                    icon-pack="feather"
                    icon="icon-edit-2"
                    class="mr-2"
                    @click="$router.push('/users/'+data[indextr].id)"
                  ></vs-button>
                </div>
              </vs-td>
            </vs-tr>
          </template>
        </vs-table>
      </vs-col>
    </vs-row>
  </div>
</template>

<script>
// import moment from 'moment'
import OnlyAdmin from '../../components/OnlyAdmin'
export default {
  components: { OnlyAdmin },
  data () {
    return {
      users: [],
      'tableList': [
        'vs-th: Component',
        'vs-tr: Component',
        'vs-td: Component',
        'thread: Slot',
        'tbody: Slot',
        'header: Slot'
      ]
    }
  },
  created () {
    this.axios.get('/users')
      .then((res) => {
        this.users = []
        res.data.users.forEach((item) => {
          this.users.push({
            id: item.id,
            name: item.name,
            email: item.email,
            status: item.status
          })
        })
      })


  },
  methods: {
    getStatusColor (status) {
      switch (status) {
        case 0:
          return 'danger'
        case 10:
          return 'success'
        default:
          return 'primary'
      }
    },
    getStatusText (status) {
      switch (status) {
        case 0:
          return 'Suspended'
        case 10:
          return 'Active'
        default:
          return 'Unknown'
      }
    }
  }


}
</script>