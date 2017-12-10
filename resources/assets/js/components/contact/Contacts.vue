<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-10 my-5 mx-auto">
        <div class="row">
          <div class="col-12 d-flex flex-column flex-lg-row justify-content-between align-items-center center-on-small-only">
            <h1 class="mt-5">Contacts</h1>
            <div class="mt-5">
              {{ contacts.length }}
              {{ contacts.length == 0 || contacts.length == 1 ? 'contact' : 'contacts' }}
            </div>

            <!--Add-->
            <app-add-contact @contactWasCreated="addContact"></app-add-contact>
          </div>
        </div>
      </div>
    </div>
    <div class="row bg-grey-light">
      <div class="col-10 mx-auto my-7">

        <!--Contact-->
        <transition-group name="highlight">
          <app-contact class="card card-custom center-on-small-only"
                       v-for="(contact, index) in contacts"
                       :data-contact="contact"
                       :key="contact.id"
                       @contactWasDeleted="removeContact(index)">
          </app-contact>
        </transition-group>

        <!--Loader-->
        <app-moon-loader :loading="loaderState"
                         :color="loader.color"
                         :size="loader.size">
        </app-moon-loader>
      </div>
    </div>
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
