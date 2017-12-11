<template>
  <div>
    <div class="col col-lg-1 hidden-md-down">
      <img src="/img/placeholders/contact-bullet.jpg"
           alt="Bullet"
           class="img-bullet">
    </div>

    <div class="col-12 col-lg-2">

      <!--Name-->
      <h5 class="mb-0"
          v-text="company.name">
      </h5>
    </div>

    <div class="col-12 col-lg-3">

      <!--Description-->
      <span class="card-content"
            v-text="company.description">
      </span>
    </div>

    <div class="col-12 col-lg-2">

      <!--Status-->
      <div class="card-content">
        <span class="card-label">Statut:</span>
        <span>{{ company.status | capitalize }}</span>
      </div>
    </div>

    <div class="col-12 col-lg-3">

      <!--Created at-->
      <div class="card-content">
        <span class="card-label">Créé:</span>
        <span v-text="getDate(company.created_at)"></span>
      </div>

      <!--Modified at-->
      <div class="card-content">
        <span class="card-label">Modifié:</span>
        <span v-text="getDate(company.updated_at)"></span>
      </div>
    </div>

    <div class="col-12 col-lg-1 center-on-small-only text-lg-right">
      <div class="dropdown">
        <a class="btn btn-transparent btn-sm"
           type="button"
           id="dropdownMenuLink"
           data-toggle="dropdown"
           aria-haspopup="true"
           aria-expanded="false">
          <i class="fal fa-ellipsis-v fa-lg" aria-hidden="true"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right"
             aria-labelledby="dropdownMenuLink">

          <!--Edit-->
          <app-edit-company :data-company="company"></app-edit-company>

          <!--Delete-->
          <a class="dropdown-item text-danger"
             role="button"
             @click.prevent="destroy">
            <i class="fal fa-times"></i>
            <span class="ml-3">Supprimer</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import EditCompany from './EditCompany.vue'
  import moment from 'moment'
  import mixins from '../../mixins'

  export default {
    props: ['data-company'],
    data() {
      return {
        company: this.dataCompany
      }
    },
    mixins: [mixins],
    components: {
      'app-edit-company': EditCompany
    },
    methods: {

      /**
       * Delete a company.
       */
      destroy() {
        axios.delete(route('companies.destroy', [this.company.id]))
        this.$emit('companyWasDeleted', this.company.id)
      },

      /**
       * Get the formatted dates.
       */
      getDate(date) {
        return moment(date).locale(this.momentLocale).format(this.momentFormat)
      }
    }
  }
</script>
