<template>
  <div>
    <div class="col col-lg-1 hidden-md-down">
      <img src="/img/placeholders/contact-bullet.jpg"
           alt="Bullet"
           class="img-bullet">
    </div>

    <div class="col-12 col-lg-2">

      <!--Username-->
      <h5 class="mb-0"
          v-text="user.username">
      </h5>
    </div>

    <div class="col-12 col-lg-3">

      <!--Role-->
      <div class="card-content">
        <span class="card-label">Role:</span>
        <span>{{ user.role | capitalize }}</span>
      </div>

      <!--Email-->
      <div class="card-content">
        <span class="card-label">Email:</span>
        <span v-text="user.email"></span>
      </div>

      <!--Company-->
      <div class="card-content">
        <span class="card-label">Société:</span>
        <span v-text="user.company.name"></span>
      </div>
    </div>

    <div class="col-12 col-lg-2">

      <!--Email confirmed-->
      <div class="card-content">
        <span class="card-label">Compte:</span>
        <span v-if="user.email_confirmed"><i class="fal fa-check-circle text-success"></i></span>
        <span v-else><i class="fal fa-times-circle text-warning"></i></span>
      </div>

      <!--Contact confirmed-->
      <div class="card-content">
        <span class="card-label">Contact:</span>
        <span v-if="user.contact_confirmed"><i class="fal fa-check-circle text-success"></i></span>
        <span v-else><i class="fal fa-times-circle text-warning"></i></span>
      </div>

      <!--Company confirmed-->
      <div class="card-content">
        <span class="card-label">Société:</span>
        <span v-if="user.company_confirmed"><i class="fal fa-check-circle text-success"></i></span>
        <span v-else><i class="fal fa-times-circle text-warning"></i></span>
      </div>

    </div>

    <div class="col-12 col-lg-3">

      <!--Created at-->
      <div class="card-content">
        <span class="card-label">Créé:</span>
        <span v-text="getDate(user.created_at)"></span>
      </div>

      <!--Modified at-->
      <div class="card-content">
        <span class="card-label">Modifié:</span>
        <span v-text="getDate(user.updated_at)"></span>
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
          <app-edit-user :data-user="user"
                         :data-companies="companies">
          </app-edit-user>

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
  import EditUser from './EditUser.vue'
  import moment from 'moment'
  import mixins from '../../mixins'

  export default {
    props: [
      'data-user',
      'data-companies'
    ],
    data() {
      return {
        user: this.dataUser,
        companies: this.dataCompanies
      }
    },
    mixins: [mixins],
    components: {
      'app-edit-user': EditUser
    },
    methods: {

      /**
       * Delete a user.
       */
      destroy() {
        axios.delete('/users/' + this.user.id)
        this.$emit('userWasDeleted', this.user.id)
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
