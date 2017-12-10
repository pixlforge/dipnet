<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-10 my-5 mx-auto">
        <div class="row">
          <div class="col-12 d-flex flex-column flex-lg-row justify-content-between align-items-center center-on-small-only">
            <h1 class="mt-5">Sociétés</h1>
            <div class="mt-5">
              {{ companies.length }}
              {{ companies.length == 0 || companies.length == 1 ? 'société' : 'sociétés' }}
            </div>

            <!--Add-->
            <app-add-company @companyWasCreated="addCompany">
            </app-add-company>
          </div>
        </div>
      </div>
    </div>
    <div class="row bg-grey-light">
      <div class="col-10 mx-auto my-7">

        <!--Company-->
        <transition-group name="highlight">
          <app-company class="card card-custom center-on-small-only"
                       v-for="(company, index) in companies"
                       :data-company="company"
                       :key="company.id"
                       @companyWasDeleted="removeCompany(index)">
          </app-company>
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
