<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-10 my-5 mx-auto">
        <div class="row">
          <div class="col-12 d-flex flex-column flex-lg-row justify-content-between align-items-center center-on-small-only">
            <h1 class="mt-5">Commandes</h1>
            <div class="mt-5">
              {{ orders.length }}
              {{ orders.length == 0 || orders.length == 1 ? 'commande' : 'commandes' }}
            </div>

            <a class="btn btn-lg btn-black light mt-5"
               role="button"
               @click="redirect()">
              <i class="fal fa-plus-circle mr-2"></i>
              Nouvelle commande
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="row bg-grey-light">
      <div class="col-10 mx-auto my-7">

        <!--Order-->
        <transition-group name="highlight">
          <app-order class="card card-custom center-on-small-only"
                     v-for="(order, index) in orders"
                     :data-order="order"
                     :key="order.id"
                     @orderWasDeleted="removeOrder(index)">
          </app-order>
        </transition-group>
      </div>
    </div>

    <!--Loader-->
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
