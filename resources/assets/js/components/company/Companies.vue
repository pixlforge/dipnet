<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Sociétés</h1>
      <div class="header__stats">
        {{ companies.length }}
        {{ companies.length == 0 || companies.length == 1 ? 'société' : 'sociétés' }}
      </div>
      <app-add-company @companyWasCreated="addCompany">
      </app-add-company>
    </div>

    <div class="main__container main__container--grey">
      <transition-group name="highlight" tag="div">
        <app-company class="card__container"
                     v-for="(company, index) in companies"
                     :data-company="company"
                     :key="company.id"
                     @companyWasDeleted="removeCompany(index)">
        </app-company>
      </transition-group>
    </div>

    <app-moon-loader :loading="loaderState"
                     :color="loader.color"
                     :size="loader.size">
    </app-moon-loader>
  </div>
</template>

<script>
  import Company from './Company.vue'
  import AddCompany from './AddCompany.vue'
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import mixins from '../../mixins'
  import { eventBus } from '../../app'
  import { mapGetters } from 'vuex'

  export default {
    props: ['data-companies'],
    data() {
      return {
        companies: this.dataCompanies
      }
    },
    mixins: [mixins],
    components: {
      'app-company': Company,
      'app-add-company': AddCompany,
      'app-moon-loader': MoonLoader
    },
    computed: {
      ...mapGetters([
        'loaderState'
      ])
    },
    methods: {

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
    }
  }
</script>
