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
          v-text="contact.name">
      </h5>
    </div>

    <div class="col-12 col-lg-3">

      <!--Address line 1-->
      <div class="card-content">
        <span class="card-label">Adresse:</span>
        <span v-text="contact.address_line1"></span>
      </div>

      <!--Address line 2-->
      <div class="card-content">
        <span v-text="contact.address_line2"></span>
      </div>

      <!--Zip-->
      <div class="card-content">
        <span class="card-label">NPA:</span>
        <span v-text="contact.zip"></span>
      </div>

      <!--City-->
      <div class="card-content">
        <span class="card-label">Ville:</span>
        <span v-text="contact.city"></span>
      </div>

    </div>

    <div class="col-12 col-lg-2 pl-0">

      <!--Phone-->
      <div class="card-content"
           v-if="contact.phone_number">
        <span class="card-label">Tel:</span>
        <span v-text="contact.phone_number"></span>
      </div>

      <!--Fax-->
      <div class="card-content"
           v-if="contact.fax">
        <span class="card-label">Fax:</span>
        <span v-text="contact.fax"></span>
      </div>

      <!--Email-->
      <div class="card-content">
        <span class="card-label">Email:</span>
        <span v-text="contact.email"></span>
      </div>
    </div>

    <div class="col-12 col-lg-3">

      <!--Company-->
      <div class="card-content">
        <span class="card-label">Société:</span>
        <span v-text="contact.company.name"></span>
      </div>

      <!--Created at-->
      <div class="card-content">
        <span class="card-label">Créé:</span>
        <span v-text="getDate(contact.created_at)"></span>
      </div>

      <!--Modified at-->
      <div class="card-content">
        <span class="card-label">Modifié:</span>
        <span v-text="getDate(contact.updated_at)"></span>
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
          <app-edit-contact :data-contact="contact"></app-edit-contact>

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
  import EditContact from './EditContact.vue'
  import moment from 'moment'
  import mixins from '../../mixins'

  export default {
    props: ['data-contact'],
    data() {
      return {
        contact: this.dataContact,
      }
    },
    mixins: [mixins],
    components: {
      'app-edit-contact': EditContact
    },
    methods: {

      /**
       * Delete a contact.
       */
      destroy() {
        axios.delete('/contacts/' + this.contact.id)
        this.$emit('contactWasDeleted', this.contact.id)
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
