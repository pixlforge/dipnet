<template>
  <div>
    <transition name="fade" mode="out-in">
      <!--Preview-->
      <div key="preview" v-if="showPreview">
        <div class="container-fluid">
          <div class="row">
            <div class="col-10 my-5 mx-auto">
              <div class="row">
                <div class="order__container">
                  <h1 class="order__title">Prévisualisation de la commande</h1>
                  <div class="order__header"></div>
                </div>
              </div>
            </div>
          </div>
          <transition-group name="order">
            <div class="row bg-red my-2"
                 v-for="(delivery, index) in listDeliveries"
                 :key="index">
              <div class="col-10 mx-auto my-6">
                <app-preview-delivery :data-order="order"
                                      :data-delivery="delivery"
                                      :data-delivery-number="index + 1"
                                      :data-documents="documents"
                                      @removeDelivery="removeDelivery">
                </app-preview-delivery>
              </div>
            </div>
          </transition-group>
        </div>
      </div>

      <!--Order-->
      <div key="order" v-else>
        <div class="container-fluid">
          <div class="row">
            <div class="col-10 my-5 mx-auto">
              <div class="row">
                <div class="order__container">
                  <h1 class="order__title">Nouvelle commande</h1>
                  <div class="order__header">
                    <!--Business-->
                    <div class="order__business">
                      <!--Dropdown-->
                      <h6 class="order__label">Affaire</h6>
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
                      <h6 class="order__label">Facturation</h6>
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
                 :key="index">
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

          <div class="order__controls"
               role="button"
               @click="addDelivery">
            <h4 class="order__controls-label">
              <i class="fal fa-plus-circle mr-2"></i>
              <span>Ajouter une livraison</span>
            </h4>
          </div>

          <div class="order__errors" v-if="errors.length">
            <i class="fal fa-exclamation-triangle"></i>
            {{ errors[0].message }}
          </div>

          <div class="order__footer">
            <button class="btn--black" @click="goToPreview()">Vers l'aperçu de la commande</button>
          </div>

          <!--Loader-->
          <app-moon-loader :loading="loaderState"
                           :color="loader.color"
                           :size="loader.size">
          </app-moon-loader>
        </div>
      </div>
    </transition>

  </div>
</template>

<script>
  import CreateDelivery from './CreateDelivery.vue'
  import PreviewDelivery from './PreviewDelivery'
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
        errors: [],
        showPreview: false
      }
    },
    mixins: [mixins],
    components: {
      'app-create-delivery': CreateDelivery,
      'app-preview-delivery': PreviewDelivery,
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
        axios.put(route('orders.update', [this.order.reference]), this.order)
          .catch(error => this.errors.push(error))
      },

      /**
       * Go to preview order page
       */
      goToPreview() {
        this.$store.dispatch('toggleLoader')
        axios.post(route('orders.validation', [this.order.reference]), this.order)
          .then(() => {
            this.errors = []
            this.$store.dispatch('toggleLoader')
            this.showPreview = true
          })
          .catch(error => {
            this.errors = []
            this.errors.push(error.response.data)
            this.$store.dispatch('toggleLoader')
          })
      }
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
