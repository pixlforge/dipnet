<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Contacts</h1>
      <div class="header__stats">
        {{ contacts.length }}
        {{ contacts.length == 0 || contacts.length == 1 ? 'contact' : 'contacts' }}
      </div>
      <app-add-contact @contactWasCreated="addContact">
      </app-add-contact>
    </div>

    <div class="main__container main__container--grey">
      <transition-group name="highlight" tag="div">
        <app-contact class="card__container"
                     v-for="(contact, index) in contacts"
                     :data-contact="contact"
                     :key="index"
                     @contactWasDeleted="removeContact(index)">
        </app-contact>
      </transition-group>
    </div>

    <app-moon-loader :loading="loaderState"
                     :color="loader.color"
                     :size="loader.size">
    </app-moon-loader>
  </div>
</template>

<script>
  import Contact from './Contact.vue'
  import AddContact from './AddContact.vue'
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import mixins from '../../mixins'
  import { eventBus } from '../../app'
  import { mapGetters } from 'vuex'

  export default {
    props: ['data-contacts'],
    data() {
      return {
        contacts: this.dataContacts
      }
    },
    mixins: [mixins],
    components: {
      'app-contact': Contact,
      'app-add-contact': AddContact,
      'app-moon-loader': MoonLoader
    },
    computed: {
      ...mapGetters([
        'loaderState'
      ])
    },
    methods: {
      /**
       * Add a new contact to the list.
       */
      addContact(contact) {
        this.contacts.unshift(contact)
        flash({
          message: 'La création du contact a réussi.',
          level: 'success'
        })
      },

      /**
       * Update a contact details.
       */
      updateContact(data) {
        for (let contact of this.contacts) {
          if (data.id === contact.id) {
            contact.name = data.name
            contact.address_line1 = data.address_line1
            contact.address_line2 = data.address_line2
            contact.zip = data.zip
            contact.city = data.city
            contact.phone_number = data.phone_number
            contact.fax = data.fax
            contact.email = data.email
            contact.company_id = data.company_id
          }
        }
        flash({
          message: 'Les modifications apportées au contact ont été enregistrées.',
          level: 'success'
        })
      },

      /**
       * Remove a contact from the list.
       */
      removeContact(index) {
        this.contacts.splice(index, 1)
        flash({
          message: 'Suppression du contact réussie.',
          level: 'success'
        })
      }
    },
    created() {
      eventBus.$on('contactWasUpdated', (data) => {
        this.updateContact(data)
      })
    }
  }
</script>
