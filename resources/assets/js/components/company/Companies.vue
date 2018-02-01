<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Sociétés</h1>
      <div class="header__stats">
        {{ meta.total }}
        {{ meta.total == 0 || meta.total == 1 ? 'société' : 'sociétés' }}
      </div>
      <app-add-company @companyWasCreated="addCompany">
      </app-add-company>
    </div>

    <div class="main__container main__container--grey">
      <app-pagination class="pagination pagination--top"
                      v-if="companies.length"
                      :data-meta="meta"
                      @paginationSwitched="getCompanies">
      </app-pagination>

      <template v-if="!companies.length && !fetching">
        <p class="paragraph__no-model-found">Il n'existe encore aucune société.</p>
      </template>

      <template v-else>
        <transition-group name="pagination" tag="div" mode="out-in">
          <app-company class="card__container"
                       v-for="(company, index) in companies"
                       :key="company.id"
                       :data-company="company"
                       @companyWasDeleted="removeCompany(index)">
          </app-company>
        </transition-group>
      </template>

      <app-pagination class="pagination pagination--bottom"
                      v-if="companies.length"
                      :data-meta="meta"
                      @paginationSwitched="getCompanies">
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
  import Company from './Company.vue'
  import AddCompany from './AddCompany.vue'
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import mixins from '../../mixins'
  import { eventBus } from '../../app'
  import { mapGetters } from 'vuex'

  export default {
    data() {
      return {
        companies: [],
        meta: {},
        errors: {},
        fetching: false
      }
    },
    mixins: [mixins],
    components: {
      'app-company': Company,
      'app-add-company': AddCompany,
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
       * Fetch the companies paginated data.
       */
      getCompanies(page = 1) {
        this.$store.dispatch('toggleLoader')
        this.fetching = true

        axios.get(route('api.companies.index'), {
          params: {
            page
          }
        }).then(response => {
          this.companies = response.data.data
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
       * Add a new company to the list.
       */
      addCompany(company) {
        this.companies.unshift(company)
        flash({
          message: 'La création de la société a réussi.',
          level: 'success'
        })
      },

      /**
       * Update a company details.
       */
      updateCompany(data) {
        for (let company of this.companies) {
          if (data.id === company.id) {
            company.name = data.name
            company.status = data.status
            company.description = data.description
          }
        }
        flash({
          message: 'Les modifications apportées à la société ont été enregistrées.',
          level: 'success'
        })
      },

      /**
       * Remove a company from the list.
       */
      removeCompany(index) {
        this.companies.splice(index, 1)
        flash({
          message: 'Suppression de la société réussie.',
          level: 'success'
        })
      }
    },
    created() {
      eventBus.$on('companyWasUpdated', (data) => {
        this.updateCompany(data)
      })
    },
    mounted() {
      this.getCompanies()
    }
  }
</script>
