<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Sociétés</h1>

      <div class="header__stats">
        <span v-text="modelCount"></span>
      </div>

      <add-company @companyWasCreated="addCompany"></add-company>
    </div>

    <div class="main__container main__container--grey">
      <pagination class="pagination pagination--top"
                  v-if="meta.total > 25"
                  :meta="meta"
                  @paginationSwitched="getCompanies"></pagination>

      <template v-if="!companies.length && !fetching">
        <p class="paragraph__no-model-found">Il n'existe encore aucune société.</p>
      </template>

      <template v-else>
        <transition-group name="pagination" tag="div" mode="out-in">
          <company class="card__container"
                   v-for="(company, index) in companies"
                   :key="company.id"
                   :company="company"
                   @companyWasDeleted="removeCompany(index)"></company>
        </transition-group>
      </template>

      <pagination class="pagination pagination--bottom"
                  v-if="meta.total > 25"
                  :meta="meta"
                  @paginationSwitched="getCompanies"></pagination>
    </div>

    <moon-loader :loading="loaderState"
                 :color="loader.color"
                 :size="loader.size"></moon-loader>
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
    components: {
      Company,
      AddCompany,
      Pagination,
      MoonLoader
    },
    data() {
      return {
        companies: [],
        meta: {},
        errors: {},
        fetching: false,
        modelNameSingular: 'société',
        modelNamePlural: 'sociétés',
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
      addCompany(company) {
        this.companies.unshift(company)
        flash({
          message: 'La création de la société a réussi.',
          level: 'success'
        })
      },
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
