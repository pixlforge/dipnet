<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Contacts</h1>

      <div class="header__stats">
        <span v-text="modelCount"></span>
      </div>

      <add-contact @contactWasCreated="addContact"></add-contact>
    </div>

    <div class="main__container main__container--grey">
      <pagination class="pagination pagination--top"
                  v-if="meta.total > 25"
                  :meta="meta"
                  @paginationSwitched="getContacts"></pagination>

      <template v-if="!contacts.length && !fetching">
        <p class="paragraph__no-model-found">Il n'existe encore aucun contact.</p>
      </template>

      <template v-else>
        <transition-group name="pagination" tag="div" mode="out-in">
          <contact class="card__container"
                   v-for="(contact, index) in contacts"
                   :key="contact.id"
                   :contact="contact"
                   @contactWasDeleted="removeContact(index)"></contact>
        </transition-group>
      </template>

      <pagination class="pagination pagination--bottom"
                  v-if="meta.total > 25"
                  :meta="meta"
                  @paginationSwitched="getContacts"></pagination>
    </div>

    <moon-loader :loading="loaderState"
                 :color="loader.color"
                 :size="loader.size"></moon-loader>
  </div>
</template>

<script>
  import Pagination from '../pagination/Pagination'
  import Contact from './Contact.vue'
  import AddContact from './AddContact.vue'
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import mixins from '../../mixins'
  import { eventBus } from '../../app'
  import { mapGetters } from 'vuex'

  export default {
    components: {
      Contact,
      AddContact,
      Pagination,
      MoonLoader
    },
    data() {
      return {
        contacts: [],
        meta: {},
        errors: {},
        fetching: false,
        modelNameSingular: 'contact',
        modelNamePlural: 'contacts',
        modelGender: 'M'
      }
    },
    computed: {
      ...mapGetters([
        'loaderState'
      ])
    },
    mixins: [mixins],
    methods: {
      getContacts(page = 1) {
        this.$store.dispatch('toggleLoader')
        this.fetching = true

        axios.get(route('api.contacts.index'), {
          params: {
            page
          }
        }).then(response => {
          this.contacts = response.data.data
          this.meta = response.data.meta
          this.$store.dispatch('toggleLoader')
          this.fetching = false
        }).catch(error => {
          this.errors = error.response.data
          this.$store.dispatch('toggleLoader')
          this.fetching = false
        })
      },
      addContact(contact) {
        this.contacts.unshift(contact)
        flash({
          message: 'La création du contact a réussi.',
          level: 'success'
        })
      },
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
    },
    mounted() {
      this.getContacts()
    }
  }
</script>
