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
          <div class="row"
               v-for="(delivery, index) in listDeliveries"
               :key="index"
               :class="'bg-red-' + (index + 1)">
            <app-preview-delivery class="preview__delivery"
                                  :data-order="order"
                                  :data-delivery="delivery"
                                  :data-delivery-number="index + 1"
                                  :data-documents="documents"
                                  @removeDelivery="removeDelivery">
            </app-preview-delivery>
          </div>

          <div class="preview__business">
            <h2>
              Associé à l'affaire
              <strong>{{ order.business.name | capitalize }}</strong>
            </h2>
            <ul class="preview__list">
              <li>{{ order.business.name }}</li>
              <li>{{ order.business.reference }}</li>
            </ul>
          </div>
          <hr>
          <div class="preview__billed-to">
            <h2>
              Facturation à
              <strong>{{ order.contact.name | capitalize }}</strong>
            </h2>
            <ul class="preview__list">
              <li>{{ order.contact.name }}</li>
              <li>{{ order.contact.address_line1 }}</li>
              <li>{{ order.contact.address_line2 }}</li>
              <li>{{ order.contact.zip }} {{ order.contact.city }}</li>
              <li>{{ order.contact.phone_number }}</li>
              <li>{{ order.contact.fax }}</li>
              <li>{{ order.contact.email }}</li>
            </ul>
          </div>
          <div class="preview__terms">
            <label>
              <input type="checkbox" v-model="terms">
              <div>
                J'ai lu et j'accepte les Conditions Générales de Vente (CGV)
              </div>
            </label>
          </div>
          <div class="preview__terms-link">
            <p><a href="javascript:;">Conditions Générales de Vente</a></p>
          </div>
          <div class="order__footer">
            <button class="btn btn--grey"
                    @click="goToOrder()">
              Retour
            </button>
            <button class="btn btn--black"
                    @click="completeOrder()"
                    :disabled="!terms">
              Commander
            </button>
          </div>
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
                      <h6 class="order__label">Affaire</h6>
                      <app-dropdown :label="selectedBusiness"
                                    :list-items="listBusinesses"
                                    @itemSelected="selectBusiness">
                      </app-dropdown>
                    </div>

                    <!--Billing-->
                    <div class="order__billing">
                      <h6 class="order__label">Facturation</h6>
                      <app-dropdown :label="selectedContact"
                                    :list-items="listContacts"
                                    add-contact-component="true"
                                    @itemSelected="selectContact">
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
            <button class="btn btn--black" @click="goToPreview()">Aperçu de la commande</button>
          </div>
        </div>
      </div>
    </transition>
    <!--Loader-->
    <app-moon-loader :loading="loaderState"
                     :color="loader.color"
                     :size="loader.size">
    </app-moon-loader>
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
        showPreview: false,
        terms: false
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
        this.order.contact = contact
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
       * Go to the preview order page.
       */
      goToPreview() {
        this.$store.dispatch('toggleLoader')
        axios.post(route('orders.validation', [this.order.reference]), this.order)
          .then(() => {
            this.errors = []
            this.$store.dispatch('toggleLoader')
            this.showPreview = true
            window.scroll({
              top: 0,
              left: 0,
              behavior: 'smooth'
            });
          })
          .catch(error => {
            this.errors = []
            this.errors.push(error.response.data)
            this.$store.dispatch('toggleLoader')
          })
      },

      /**
       * Go the the order page
       */
      goToOrder() {
        this.showPreview = false
      },

      /**
       * Order
       */
      completeOrder() {
        this.$store.dispatch('toggleLoader')
        axios.post(route('orders.validation', [this.order.reference]), this.order)
          .then(() => {
            axios.patch(route('orders.complete', [this.order.reference]), this.order)
              .then(() => {
                flash({
                  message: "Votre commande a bien été envoyée!",
                  level: 'success'
                })
                setTimeout(() => {
                  window.location = route('orders.index')
                }, 1500)
              })
              .catch(error => {
                console.log(error)
                this.$store.dispatch('toggleLoader')
              })
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
