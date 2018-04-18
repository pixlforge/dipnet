<template>
  <div>
    <div class="header__container">

      <!--Page title-->
      <h1 class="header__title">Livraisons</h1>

      <!--Deliveries count-->
      <div class="header__stats">
        <span v-text="modelCount"></span>
      </div>

      <div></div>
    </div>

    <div class="main__container main__container--grey">

      <!--Pagination top-->
      <app-pagination class="pagination pagination--top"
                      v-if="meta.total > 25"
                      :data-meta="meta"
                      @paginationSwitched="getDeliveries">
      </app-pagination>

      <template v-if="!deliveries.length && !fetching">
        <p class="paragraph__no-model-found">Il n'existe encore aucune livraison.</p>
      </template>

      <template v-else>
        <transition-group name="pagination" tag="div" mode="out-in">
          <app-delivery class="card__container"
                        v-for="(delivery, index) in deliveries"
                        :key="delivery.id"
                        :data-delivery="delivery"
                        @deliveryWasDeleted="removeDelivery(index)">
          </app-delivery>
        </transition-group>
      </template>

      <!--Pagination bottom-->
      <app-pagination class="pagination pagination--bottom"
                      v-if="meta.total > 25"
                      :data-meta="meta"
                      @paginationSwitched="getDeliveries">
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
  import Delivery from './Delivery'
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import mixins from '../../mixins'
  import { mapGetters } from 'vuex'

  export default {
    data() {
      return {
        deliveries: [],
        meta: {},
        errors: {},
        fetching: false,
        modelNameSingular: 'livraison',
        modelNamePlural: 'livraisons',
        modelGender: 'F'
      }
    },
    mixins: [mixins],
    components: {
      'app-delivery': Delivery,
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
       * Fetch the users paginated data.
       */
      getDeliveries(page = 1) {
        this.$store.dispatch('toggleLoader')
        this.fetching = true

        axios.get(route('api.deliveries.index'), {
          params: {
            page
          }
        }).then(response => {
          this.deliveries = response.data.data
          this.meta = response.data.meta
          this.$store.dispatch('toggleLoader')
          this.fetching = false
        }).catch(error => {
          this.errors = error.response.data
          this.$store.dispatch('toggleLoader')
          this.fetching = false
        })
      },
    },
    mounted() {
      this.getDeliveries()
    }
  }
</script>