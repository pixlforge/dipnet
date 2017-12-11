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
          v-text="business.name">
      </h5>
    </div>

    <div class="col-12 col-lg-3 pl-0">

      <!--Reference-->
      <div class="card-content">
        <span class="card-label">Référence:</span>
        <span v-text="business.reference"></span>
      </div>

      <!--Description-->
      <div class="card-content"
           v-if="business.description">
        <span class="card-label">Description:</span>
        <span v-text="business.description"></span>
      </div>
    </div>

    <div class="col-12 col-lg-2 pl-0">

      <!--Company-->
      <div class="card-content">
        <span class="card-label">Société:</span>
        <span v-text="business.company.name"></span>
      </div>

      <!--Contact-->
      <div class="card-content">
        <span class="card-label">Contact:</span>
        <span v-text="business.contact.name"></span>
      </div>

      <!--Created by username-->
      <div class="card-content">
        <span class="card-label">Créé par:</span>
        <span v-text="business.created_by_username"></span>
      </div>
    </div>

    <div class="col-12 col-lg-3">

      <!--Created at-->
      <div class="card-content">
        <span class="card-label">Créé:</span>
        <span v-text="getDate(business.created_at)"></span>
      </div>

      <!--Modified at-->
      <div class="card-content">
        <span class="card-label">Modifié:</span>
        <span v-text="getDate(business.updated_at)"></span>
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
          <i class="fal fa-ellipsis-v fa-lg"
             aria-hidden="true">
          </i>
        </a>
        <div class="dropdown-menu dropdown-menu-right"
             aria-labelledby="Dropdown menu link">

          <!--Edit-->
          <app-edit-business :data-business="business"
                             :data-companies="companies">
          </app-edit-business>

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
  import EditBusiness from './EditBusiness.vue'
  import mixins from '../../mixins'
  import moment from 'moment'

  export default {
    props: [
      'data-business',
      'data-companies'
    ],
    data() {
      return {
        business: this.dataBusiness,
        companies: this.dataCompanies
      }
    },
    mixins: [mixins],
    components: {
      'app-edit-business': EditBusiness
    },
    methods: {
      /**
       * Delete a business.
       */
      destroy() {
        axios.delete(route('businesses.destroy', [this.business.id]))
        this.$emit('businessWasDeleted', this.business.id)
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
