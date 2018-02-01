<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Affaires</h1>
      <div class="header__stats">
        {{ meta.total }}
        {{ meta.total == 0 || meta.total == 1 ? 'affaire' : 'affaires' }}
      </div>
      <app-add-business :data-companies="companies"
                        :data-contacts="dataContacts"
                        :data-user="dataUser"
                        @businessWasCreated="addBusiness">
      </app-add-business>
    </div>

    <div class="main__container main__container--grey">
      <app-pagination class="pagination pagination--top"
                      :data-meta="meta"
                      @paginationSwitched="getBusinesses">
      </app-pagination>

      <transition-group name="pagination" tag="div" mode="out-in">
        <app-business class="card__container"
                      v-for="(business, index) in businesses"
                      :key="business.id"
                      :data-business="business"
                      :data-companies="dataCompanies"
                      :data-contacts="dataContacts"
                      @businessWasDeleted="removeBusiness(index)">
        </app-business>
      </transition-group>

      <app-pagination class="pagination pagination--bottom"
                      :data-meta="meta"
                      @paginationSwitched="getBusinesses">
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
  import Business from './Business.vue'
  import AddBusiness from './AddBusiness.vue'
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import mixins from '../../mixins'
  import { eventBus } from '../../app'
  import { mapGetters } from 'vuex'

  export default {
    props: [
      'data-companies',
      'data-contacts',
      'data-user'
    ],
    data() {
      return {
        businesses: [],
        companies: this.dataCompanies,
        meta: {}
      }
    },
    mixins: [mixins],
    components: {
      'app-business': Business,
      'app-add-business': AddBusiness,
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
       * Fetch the businesses paginated data.
       */
      getBusinesses(page = 1) {
        this.$store.dispatch('toggleLoader')

        axios.get(route('api.businesses.index'), {
          params: {
            page
          }
        }).then(response => {
          this.businesses = response.data.data
          this.meta = response.data.meta
          this.$store.dispatch('toggleLoader')
        })
      },

      /**
       * Add a new business to the list.
       */
      addBusiness(business) {
        this.businesses.unshift(business)
        flash({
          message: "La création de l'affaire a réussi.",
          level: 'success'
        })
      },

      /**
       * Update a business details.
       */
      updateBusiness(data) {
        for (let business of this.businesses) {
          if (data.id === business.id) {
            business.name = data.name
            business.reference = data.reference
            business.description = data.description
            business.company_id = data.company_id
            business.contact_id = data.contact_id
          }
        }
        flash({
          message: "Les modifications apportées à l'affaire ont été enregistrées.",
          level: 'success'
        })
      },

      /**
       * Remove a business from the list.
       */
      removeBusiness(index) {
        this.businesses.splice(index, 1)
        flash({
          message: 'Suppression de l\'affaire réussie.',
          level: 'success'
        })
      }
    },
    created() {
      eventBus.$on('businessWasUpdated', (data) => {
        this.updateBusiness(data)
      })
    },
    mounted() {
      this.getBusinesses()
    }
  }
</script>