<template>
  <div class="user-business__card">
    <div class="user-business__card-content" @click.prevent="toggleEditBusiness">
      <img :src="iconColor" class="user-business__img" :alt="iconAlt">
      <h2 class="user-business__title">{{ dataBusiness.name }}</h2>
      <p class="user-business__orders">{{ orders }}</p>
    </div>

    <app-edit-user-business class="v-hidden"
                            :data-business="dataBusiness"
                            :data-contacts="dataContacts"
                            :data-open="open"
                            @closeEditBusiness="closeEditBusiness">
    </app-edit-user-business>
  </div>
</template>

<script>
  import EditUserBusiness from './EditUserBusiness'

  export default {
    props: [
      'data-business',
      'data-contacts',
      'data-orders'
    ],
    data() {
      return {
        open: false
      }
    },
    components: {
      'app-edit-user-business': EditUserBusiness
    },
    computed: {
      iconColor() {
        if (this.dataBusiness.folder_color === 'rouge') {
          return '/img/folders/folder-red.svg'
        } else if (this.dataBusiness.folder_color === 'orange') {
          return '/img/folders/folder-orange.svg'
        } else if (this.dataBusiness.folder_color === 'violet') {
          return '/img/folders/folder-purple.svg'
        } else {
          return '/img/folders/folder-blue.svg'
        }
      },

      iconAlt() {
        return this.dataBusiness.name
      },

      orders() {
        let count = 0
        this.dataOrders.forEach(order => {
          if (order.business_id === this.dataBusiness.id) {
            count++
          }
        })
        return count > 1 ? `${count} commandes` : `${count} commande`
      }
    },
    methods: {
      toggleEditBusiness() {
        this.open = !this.open
      },

      closeEditBusiness() {
        this.open = false
      }
    }
  }
</script>