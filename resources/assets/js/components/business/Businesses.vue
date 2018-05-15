<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Affaires</h1>

      <div class="header__stats">
        <span v-if="meta.total > 1">{{ meta.total }} affaires</span>
        <span v-else-if="meta.total === 1">{{ meta.total }} affaire</span>
        <span v-else>Aucune affaire</span>
      </div>

      <add-business :companies="companies"
                    :contacts="contacts"
                    :user="user"
                    @businessWasCreated="addBusiness"></add-business>
    </div>

    <div class="main__container main__container--grey">
      <pagination class="pagination pagination--top"
                  v-if="meta.total > 25"
                  :data-meta="meta"
                  @paginationSwitched="getBusinesses"></pagination>

      <template v-if="!businesses.length && !fetching">
        <p class="paragraph__no-model-found">Il n'existe encore aucune affaire.</p>
      </template>

      <template v-if="businesses.length && user.role === 'utilisateur'">
        <div class="user-business__container">
          <transition-group name="pagination" tag="div" mode="out-in">
            <user-business v-for="(business, index) in businesses"
                           :key="business.id"
                           :business="business"
                           :orders="orders"
                           :user="user"
                           @businessWasDeleted="removeBusiness(index)"></user-business>
          </transition-group>
        </div>
      </template>

      <template v-if="businesses.length && user.role === 'administrateur'">
        <transition-group name="pagination" tag="div" mode="out-in">
          <business class="card__container"
                    v-for="(business, index) in businesses"
                    :key="business.id"
                    :business="business"
                    :companies="companies"
                    :contacts="contacts"
                    :user="user"
                    @businessWasDeleted="removeBusiness(index)"></business>
        </transition-group>
      </template>

      <pagination class="pagination pagination--bottom"
                  v-if="meta.total > 25"
                  :data-meta="meta"
                  @paginationSwitched="getBusinesses"></pagination>
    </div>

    <moon-loader :loading="loaderState"
                 :color="loader.color"
                 :size="loader.size"></moon-loader>
  </div>
</template>

<script>
  import Pagination from '../pagination/Pagination'
  import Business from './Business.vue'
  import UserBusiness from './UserBusiness'
  import AddBusiness from './AddBusiness.vue'
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import mixins from '../../mixins'
  import { eventBus } from '../../app'
  import { mapGetters } from 'vuex'

  export default {
    components: {
      Business,
      UserBusiness,
      AddBusiness,
      Pagination,
      MoonLoader
    },
    props: {
      companies: {
        type: Array,
        required: true
      },
      contacts: {
        type: Array,
        required: true
      },
      user: {
        type: Object,
        required: true
      },
      orders: {
        type: Array,
        required: true
      }
    },
    data() {
      return {
        businesses: [],
        meta: {},
        errors: {},
        fetching: false,
        modelNameSingular: 'affaire',
        modelNamePlural: 'affaires',
        modelGender: 'F'
      }
    },
    mixins: [mixins],
    computed: {
      ...mapGetters([
        'loaderState'
      ])
    },
    methods: {
      getBusinesses(page = 1) {
        this.$store.dispatch('toggleLoader')
        this.fetching = true

        axios.get(route('api.businesses.index'), {
          params: {
            page
          }
        }).then(response => {
          this.businesses = response.data.data
          this.meta = response.data.meta
          this.$store.dispatch('toggleLoader')
          this.fetching = false
        }).catch(error => {
          this.errors = error.response.data
          this.$store.dispatch('toggleLoader')
          this.fetching = false
        })
      },
      addBusiness(business) {
        this.businesses.unshift(business)
        flash({
          message: "La création de l'affaire a réussi.",
          level: 'success'
        })
      },
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