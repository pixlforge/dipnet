<template>
  <div>
    <div class="card__img">
      <img src="/img/placeholders/contact-bullet.jpg"
           alt="Bullet point image">
    </div>

    <div class="card__title">
      {{ contact.name | capitalize }}
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Adresse</span>
        {{ contact.address_line1 | capitalize }}
      </div>
      <div>
        {{ contact.address_line2 | capitalize }}
      </div>
      <div>
        <span class="card__label">Localité</span>
        {{ contact.zip }} {{ contact.city }}
      </div>
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Tel</span>
        {{ contact.phone_number }}
      </div>
      <div>
        <span class="card__label">Fax</span>
        {{ contact.fax }}
      </div>
      <div>
        <span class="card__label">Email</span>
        {{ contact.email }}
      </div>
      <div v-if="contact.company">
        <span class="card__label">Société</span>
        {{ contact.company.name }}
      </div>
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Créé</span>
        {{ getDate(contact.created_at) }}
      </div>
      <div>
        <span class="card__label">Modifié</span>
        {{ getDate(contact.updated_at) }}
      </div>
    </div>

    <div class="card__controls">
      <div title="Modifier">
        <app-edit-contact :data-contact="contact">
        </app-edit-contact>
      </div>
      <div title="Supprimer"
           @click="destroy">
        <i class="fal fa-times"></i>
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
        axios.delete(route('contacts.destroy', [this.contact.id]))
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
