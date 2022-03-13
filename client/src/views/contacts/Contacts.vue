<template>
  <div>
    <vs-row>
      <vs-col :class="'text-right'">
        <vs-button color="success" type="border" @click="$router.push('/contacts/new')">New Contact</vs-button>
      </vs-col>
    </vs-row>
    <vs-row>
      <vs-col>
        <vs-table 
          search 
          pagination 
          max-items="10"
          :data="contacts"
        >
          <template slot="thead">
            <vs-th sort-key="name">Name</vs-th>
            <vs-th sort-key="email">Email</vs-th>
            <vs-th sort-key="phone">Phone</vs-th>
            <vs-th sort-key="address">Address</vs-th>
            <vs-th sort-key="subscribed">Subscribed</vs-th>
            <vs-th>Actions</vs-th>
          </template>

          <template slot-scope="{data}">
            <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
              <vs-td :data="data[indextr].name">
                {{ data[indextr].name }}
              </vs-td>
              <vs-td :data="data[indextr].email">
                {{ data[indextr].email }}
              </vs-td>
              <vs-td :data="data[indextr].phone">
                {{ data[indextr].phone }}
              </vs-td>
              <vs-td :data="data[indextr].address">
                {{ data[indextr].address }}
              </vs-td>
              <vs-td :data="data[indextr].subscribed">
                {{ data[indextr].subscribed }}
              </vs-td>
              <vs-td>
                <div class="flex">
                  <vs-button
                    type="border"
                    size="small"
                    icon-pack="feather"
                    icon="icon-edit-2"
                    class="mr-2"
                    @click="$router.push('/contacts/'+data[indextr].id)"
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

export default {
  data() {
    return {
      contacts: [],
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
  created() {
    this.axios.post('/contacts')
    .then((res) => {
      this.contacts = []
      res.data.contacts.forEach((item) => {
        this.contacts.push({
          name: item.name, 
          email: item.email, 
          phone: item.phone, 
          address: item.address, 
          subscribed: item.subscribed
        })
      })
    })
    

  }
  

}
</script>