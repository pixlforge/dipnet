<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-10 my-5 mx-auto">
        <div class="row">
          <div
            class="col-12 d-flex flex-column flex-lg-row justify-content-between align-items-center center-on-small-only">

            <h1 class="mt-5">Nouvelle commande</h1>

            <div class="d-flex mt-5">
              <!--Business-->
              <div class="mr-5">
                <!--Dropdown-->
                <h6 class="h6-responsive light mr-2">Affaire</h6>
                <app-dropdown :data="listBusinesses" @itemWasSelected="selectBusiness">
                  <slot>
                    <h6 class="light v-dropdown-label">
                      <strong class="v-dropdown-label-content">{{ selectedBusiness }}</strong>
                      <i class="fas fa-caret-down ml-3"></i>
                    </h6>
                  </slot>
                </app-dropdown>
              </div>

              <!--Billing Contact-->
              <div>
                <!--Dropdown-->
                <h6 class="h6-responsive light mr-2">Facturation</h6>
                <app-dropdown :data="listContacts" @itemWasSelected="selectContact">
                  <slot>
                    <h6 class="light v-dropdown-label">
                      <strong class="v-dropdown-label-content">{{ selectedContact }}</strong>
                      <i class="fas fa-caret-down ml-3"></i>
                    </h6>
                  </slot>
                </app-dropdown>
              </div>
            </div>

            <!--Add Contact-->
            <app-add-contact class="v-hidden"
                             @contactWasCreated="addContact">
            </app-add-contact>
          </div>
        </div>
      </div>
    </div>

    <transition-group name="order">
      <div class="row bg-grey-light my-2"
           v-for="(delivery, index) in listDeliveries"
           :key="delivery">
        <div class="col-10 mx-auto my-6">
          <app-create-delivery :data-order="order"
                               :data-delivery="delivery"
                               :data-delivery-number="index + 1"
                               :data-documents="documents"
                               @removeDelivery="removeDelivery">
          </app-create-delivery>
        </div>
      </div>
    </transition-group>

    <div class="row bg-grey-light bg-grey-light-hoverable my-2"
         role="button"
         @click="addDelivery">
      <div class="col-10 mx-auto my-6">
        <h4 class="text-center">
          <i class="fal fa-plus-circle mr-2"></i>
          <span class="light">Ajouter une livraison</span>
        </h4>
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
  import CreateDelivery from './CreateDelivery.vue'
  import AddContact from '../contact/AddContact.vue'
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import mixins from '../../mixins'
  import { eventBus } from '../../app'
  import { mapActions, mapGetters } from 'vuex'

  export default {
    props: [
      'data-order',
      'data-businesses',
      'data-contacts',
      'data-deliveries',
      'data-documents',
      'data-articles'
    ],
    data() {
      return {
        order: this.dataOrder,
        documents: this.dataDocuments,
        business: 'Choisissez une affaire',
        selectedBusiness: 'Affaire',
        selectedContact: 'Contact',
        errors: {}
      }
    },
    mixins: [mixins],
    components: {
      'app-create-delivery': CreateDelivery,
      'app-add-contact': AddContact,
      'app-moon-loader': MoonLoader
    },
    computed: {
      ...mapGetters([
        'loaderState',
        'listBusinesses',
        'listContacts',
        'listDeliveries',
        'listDocuments'
      ])
    },
    methods: {
      ...mapActions([
        'toggleLoader',
        'hydrateArticleTypes',
        'hydrateBusinesses',
        'hydrateContacts',
        'hydrateDeliveries',
        'addDelivery',
        'hydrateDocuments',
        'removeDocument'
      ]),

      /**
       * Add a new delivery.
       */
      addDelivery() {
        this.$store.dispatch('addDelivery', this.order)
          .then(() => flash({
            message: "Une nouvelle livraison a été ajoutée à votre commande.",
            level: 'success'
          }))
          .catch(() => flash({
            message: "Il y a eu un problème lors de la création de votre livraison.",
            level: 'danger'
          }))
      },

      /**
       * Remove a delivery from the order.
       */
      removeDelivery(delivery) {
        this.$store.dispatch('removeDelivery', delivery)
          .then(() => flash({
            message: "La livraison a bien été supprimée.",
            level: 'success'
          }))
          .catch(() => flash({
            message: "Il y a eu un problème lors de la suppression de la livraison.",
            level: 'danger'
          }))
      },

      /**
       * Update a document's details.
       */
      updateDocument(payload) {
        this.$store.dispatch('updateDocument', payload)
          .catch(error => console.log(error))
      },

      /**
       * Remove a document from a delivery.
       */
      removeDocument(payload) {
        this.$store.dispatch('removeDocument', payload)
          .then(() => flash({
            message: "Le document a bien été supprimé.",
            level: 'success'
          }))
          .catch(() => flash({
            message: "Il y a eu un problème lors de la suppression du document.",
            level: 'danger'
          }))
      },

      /**
       * Add a new contact.
       */
      addContact(contact) {
        this.$store.dispatch('addContact', contact)
          .then(() => flash({
            message: "La création du contact a réussi.",
            level: 'success'
          }))
      },

      /**
       * Select a business using the dropdown component.
       */
      selectBusiness(business) {
        this.selectedBusiness = business.name
        this.order.business_id = business.id
        this.update()
      },

      /**
       * Select a contact using the dropdown component.
       */
      selectContact(contact) {
        this.selectedContact = contact.name
        this.order.contact_id = contact.id
        this.update()
      },

      /**
       * Update the order.
       */
      update() {
        axios.put('/orders/' + this.order.reference, this.order)
      },
    },
    created() {
      /**
       * Update a document.
       */
      eventBus.$on('updateDocument', (document) => {
        this.updateDocument(document)
      })

      /**
       * Delete a document.
       */
      eventBus.$on('removeDocument', (document) => {
        this.removeDocument(document)
      })

      /**
       * Set the selected business for the order.
       */
      if (this.dataOrder.business) {
        this.selectedBusiness = this.order.business.name
      }

      /**
       * Set the selected billing contact for the order.
       */
      if (this.dataOrder.contact) {
        this.selectedContact = this.order.contact.name
      }

      /**
       * Hydrate the store.
       */
      this.hydrateArticleTypes(this.dataArticles)
      this.hydrateBusinesses(this.dataBusinesses)
      this.hydrateContacts(this.dataContacts)
      this.hydrateDeliveries(this.dataDeliveries)
      this.hydrateDocuments(this.dataDocuments)
    },
    mounted() {
      /**
       * Add a delivery if none exist.
       */
      if (!this.listDeliveries.length) this.addDelivery()
    },
  }
</script>
