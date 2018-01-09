<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Commandes</h1>
      <div class="header__stats">
        {{ orders.length }}
        {{ orders.length == 0 || orders.length == 1 ? 'commande' : 'commandes' }}
      </div>
      <button class="btn btn--black-large"
              @click="redirect()">
        <i class="fal fa-plus-circle"></i>
        Nouvelle commande
      </button>
    </div>

    <div class="main__container main__container--grey">
      <transition-group name="highlight" tag="div">
        <app-order class="card__container"
                   v-for="(order, index) in orders"
                   :key="index"
                   :data-order="order"
                   @orderWasDeleted="removeOrder(index)">
        </app-order>
      </transition-group>
    </div>

    <app-moon-loader :loading="loaderState"
                     :color="loader.color"
                     :size="loader.size">
    </app-moon-loader>
  </div>
</template>

<script>
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import Order from './Order.vue'
  import AddOrder from './CreateOrder.vue'
  import mixins from '../../mixins'
  import { eventBus } from '../../app'
  import { mapGetters } from 'vuex'

  export default {
    props: ['data-orders'],
    data() {
      return {
        orders: this.dataOrders
      }
    },
    mixins: [mixins],
    components: {
      'app-order': Order,
      'app-add-order': AddOrder,
      'app-moon-loader': MoonLoader
    },
    computed: {
      ...mapGetters([
        'loaderState'
      ])
    },
    methods: {
      /**
       * Redirect to /orders/create route.
       */
      redirect() {
        window.location = route('orders.create.start')
      },

      /**
       * Update the order.
       */
      updateOrder(data) {
        for (let order of this.orders) {
          if (data.id === order.id) {
            // TODO: Update attributes
          }
        }
        flash({
          message: 'Les modifications apportées à la commande ont été enregistrées.',
          level: 'success'
        })
      },

      /**
       * Delete an order.
       */
      removeOrder(index) {
        this.orders.splice(index, 1)
        flash({
          message: 'Suppression de la commande réussie.',
          level: 'success'
        })
      }
    },
    created() {
      eventBus.$on('orderWasUpdated', (data) => {
        this.updateOrder(data)
      })
    },
  }
</script>
