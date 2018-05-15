<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Commandes</h1>

      <div class="header__stats">
        <span v-if="meta.total > 1">{{ meta.total }} commandes</span>
        <span v-else-if="meta.total === 1">{{ meta.total }} commande</span>
        <span v-else>Aucune commande</span>
      </div>

      <button class="btn btn--red-large"
              role="button"
              @click="redirect()">
        <i class="fal fa-plus-circle"></i>
        Nouvelle commande
      </button>
    </div>

    <div class="main__container main__container--grey">
      <pagination class="pagination pagination--top"
                  v-if="meta.total > 25"
                  :data-meta="meta"
                  @paginationSwitched="getOrders"></pagination>

      <template v-if="!orders.length && !fetching">
        <p class="paragraph__no-model-found">Il n'existe encore aucune commande.</p>
      </template>

      <template v-else>
        <transition-group name="pagination" tag="div" mode="out-in">
          <order class="card__container"
                 v-for="(order, index) in orders"
                 :key="order.id"
                 :order="order"
                 :user-role="userRole"
                 @orderWasDeleted="removeOrder"></order>
        </transition-group>
      </template>

      <pagination class="pagination pagination--bottom"
                  v-if="meta.total > 25"
                  :data-meta="meta"
                  @paginationSwitched="getOrders"></pagination>
    </div>

    <moon-loader :loading="loaderState"
                 :color="loader.color"
                 :size="loader.size"></moon-loader>
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
    components: {
      Order,
      AddOrder,
      Pagination,
      MoonLoader
    },
    props: {
      userRole: {
        type: String,
        required: true
      }
    },
    data() {
      return {
        orders: [],
        meta: {},
        errors: {},
        fetching: false,
        modelNameSingular: 'commande',
        modelNamePlural: 'commandes',
        modelGender: 'F'
      }
    },
    computed: {
      ...mapGetters([
        'loaderState'
      ])
    },
    mixins: [mixins],
    methods: {
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
      redirect() {
        window.location = route('orders.create.start')
      },
      removeOrder(payload) {
        let index
        index = this.orders.findIndex(order => {
          return order.id === payload.id
        })
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
