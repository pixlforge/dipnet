<template>
  <div class="user-business__card">
    <img :src="iconColor" class="user-business__img" :alt="iconAlt">
    <h2 class="user-business__title">{{ dataBusiness.name }}</h2>
    <p class="user-business__orders">{{ orders }}</p>
  </div>
</template>

<script>
  export default {
    props: [
      'data-business',
      'data-contacts',
      'data-orders'
    ],
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
    }
  }
</script>