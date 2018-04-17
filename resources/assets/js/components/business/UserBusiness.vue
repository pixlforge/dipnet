<template>
  <div class="user-business__card" @click="showBusiness">
    <div class="user-business__card-content">
      <img :src="iconColor" class="user-business__img" :alt="iconAlt">
      <h2 class="user-business__title">{{ dataBusiness.name }}</h2>
      <p class="user-business__orders">{{ orders }}</p>
    </div>
  </div>
</template>

<script>
  export default {
    props: [
      'data-business',
      'data-orders'
    ],
    computed: {
      iconColor() {
        if (this.dataBusiness.folder_color === 'red') {
          return '/img/folders/folder-red.svg'
        } else if (this.dataBusiness.folder_color === 'orange') {
          return '/img/folders/folder-orange.svg'
        } else if (this.dataBusiness.folder_color === 'purple') {
          return '/img/folders/folder-purple.svg'
        } else if (this.dataBusiness.folder_color === 'blue') {
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
      showBusiness() {
        window.location = route('businesses.show', [this.dataBusiness.id])
      }
    }
  }
</script>