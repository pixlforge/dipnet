<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Commandes</h1>
      <div class="header__stats">
        {{ meta.total }}
        {{ meta.total == 0 || meta.total == 1 ? 'commande' : 'commandes' }}
      </div>
      <button class="btn btn--red-large"
              @click="redirect()">
        <i class="fal fa-plus-circle"></i>
        Nouvelle commande
      </button>
    </div>

    <div class="main__container main__container--grey">
      <app-pagination class="pagination pagination--top"
                      v-if="meta.total > 25"
                      :data-meta="meta"
                      @paginationSwitched="getOrders">
      </app-pagination>

      <template v-if="!orders.length && !fetching">
        <p class="paragraph__no-model-found">Il n'existe encore aucune commande.</p>
      </template>

      <template v-else>
        <transition-group name="pagination" tag="div" mode="out-in">
          <app-order class="card__container"
                     v-for="(order, index) in orders"
                     :key="order.id"
                     :data-order="order"
                     :data-user-role="dataUserRole"
                     @orderWasDeleted="removeOrder(index)">
          </app-order>
        </transition-group>
      </template>

      <app-pagination class="pagination pagination--bottom"
                      v-if="meta.total > 25"
                      :data-meta="meta"
                      @paginationSwitched="getOrders">
      </app-pagination>
    </div>

    <app-moon-loader :loading="loaderState"
                     :color="loader.color"
                     :size="loader.size">
    </app-moon-loader>
  </div>
</template>

<script>
  import Pagination from '../pagination/Pagination'
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import Order from './Order.vue'
  import AddOrder from './CreateOrder.vue'
  import mixins from '../../mixins'
  import { eventBus } from '../../app'
  import { mapGetters } from 'vuex'

  export default {
    props: {
      dataUserRole: {
        type: String,
        required: true
      }
    },
    data() {
      return {
        orders: [],
        meta: {},
        errors: {},
        fetching: false
      }
    },
    mixins: [mixins],
    components: {
      'app-order': Order,
      'app-add-order': AddOrder,
      'app-pagination': Pagination,
      'app-moon-loader': MoonLoader
    },
    computed: {
      ...mapGetters([
        'loaderState'
      ])
    },
    methods: {
      /**
       * Fetch the orders paginated data.
       */
      getOrders(page = 1) {
        this.$store.dispatch('toggleLoader')
        this.fetching = true

        axios.get(route('api.orders.index'), {
          params: {
            page
          }
        }).then(response => {
          this.orders = response.data.data
          this.meta = response.data.meta
          this.$store.dispatch('toggleLoader')
          this.fetching = false
        }).catch(error => {
          this.errors = error.response.data
          this.$store.dispatch('toggleLoader')
          this.fetching = false
        })
      },

      /**
       * Redirect to /orders/create route.
       */
      redirect() {
        window.location = route('orders.create.start')
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
    mounted() {
      this.getOrders()
    }
  }
</script>
