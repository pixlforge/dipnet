<template>
  <div>
    <transition name="fade" mode="out-in">

      <!--Preview-->
      <div key="preview" v-if="showPreview">
        <div class="header__container">
          <h1 class="header__title">Prévisualisation avant commande</h1>
          <div></div>
        </div>
        <preview-delivery v-for="(delivery, index) in listDeliveries"
                          :key="index"
                          class="delivery__container"
                          :class="'bg-red-' + (index + 1)"
                          :order="order"
                          :delivery="delivery"
                          :delivery-number="index + 1"
                          :documents="documents"
                          @removeDelivery="removeDelivery"></preview-delivery>
        <div class="delivery__business">
          <h2>
            Associé à l'affaire
            <strong>{{ order.business.name | capitalize }}</strong>
          </h2>
          <ul class="delivery__list">
            <li>{{ order.business.name }}</li>
            <li>{{ order.business.reference }}</li>
          </ul>
        </div>
        <div class="delivery__billed-to">
          <h2>
            Facturation à
            <strong>{{ order.contact.name | capitalize }}</strong>
          </h2>
          <ul class="delivery__list">
            <li>{{ order.contact.name }}</li>
            <li>{{ order.contact.address_line1 }}</li>
            <li>{{ order.contact.address_line2 }}</li>
            <li>{{ order.contact.zip }} {{ order.contact.city }}</li>
            <li>{{ order.contact.phone_number }}</li>
            <li>{{ order.contact.fax }}</li>
            <li>{{ order.contact.email }}</li>
          </ul>
        </div>
        <div class="delivery__terms">
          <label>
            <input type="checkbox" v-model="terms">
            <div>
              J'ai lu et j'accepte les Conditions Générales de Vente (CGV)
            </div>
          </label>
        </div>
        <div class="delivery__terms-link">
          <p><a href="javascript:;">Conditions Générales de Vente</a></p>
        </div>
        <div class="order__footer">
          <button class="btn btn--grey"
                  role="button"
                  @click="goToOrder()">
            Retour
          </button>
          <button class="btn btn--red"
                  role="button"
                  :disabled="!terms"
                  @click="completeOrder()">
            Commander
          </button>
        </div>
      </div>

      <!--Order-->
      <div key="order" v-else>
        <div class="header__container">
          <h1 class="header__title">Nouvelle commande</h1>
          <div class="order__header">

            <!--Business-->
            <div class="order__business">
              <h6 class="order__label">Affaire</h6>
              <dropdown :label="selectedBusiness"
                        :list-items="listBusinesses"
                        @itemSelected="selectBusiness"></dropdown>
            </div>

            <!--Billing-->
            <div class="order__billing">
              <h6 class="order__label">Facturation</h6>
              <dropdown :label="selectedContact"
                        :list-items="listContacts"
                        :add-contact-component="true"
                        @itemSelected="selectContact"></dropdown>
            </div>
          </div>

          <!--Add Contact-->
          <add-contact class="v-hidden"
                       :user="user"
                       @contactWasCreated="addContact"></add-contact>
        </div>

        <transition-group name="order">
          <create-delivery class="delivery"
                           v-for="(delivery, index) in listDeliveries"
                           :key="index"
                           :order="order"
                           :delivery="delivery"
                           :delivery-number="index + 1"
                           :documents="documents"
                           @removeDelivery="removeDelivery"></create-delivery>
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
          <button class="btn btn--red"
                  role="button"
                  @click="goToPreview()">
            Aperçu de la commande
          </button>
        </div>

      </div>
    </transition>

    <moon-loader :loading="loaderState"
                 :color="loader.color"
                 :size="loader.size"></moon-loader>
  </div>
</template>

<script>
  import CreateDelivery from './CreateDelivery.vue'
  import PreviewDelivery from './PreviewDelivery'
  import AddContact from '../contact/AddContact.vue'
  import Dropdown from '../dropdown/Dropdown'
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import mixins from '../../mixins'
  import { eventBus } from '../../app'
  import { mapActions, mapGetters } from 'vuex'

  export default {
    components: {
      CreateDelivery,
      PreviewDelivery,
      AddContact,
      Dropdown,
      MoonLoader
    },
    props: {
      order: {
        type: Object,
        required: true
      },
      businesses: {
        type: Array,
        required: true
      },
      contacts: {
        type: Array,
        required: true
      },
      deliveries: {
        type: Array,
        required: true
      },
      documents: {
        type: Array,
        required: true
      },
      articles: {
        type: Array,
        required: true
      },
      user: {
        type: Object,
        required: true
      }
    },
    data() {
      return {
        business: 'Choisissez une affaire',
        selectedBusiness: 'Affaire',
        selectedContact: 'Contact',
        errors: [],
        showPreview: false,
        terms: false
      }
    },
    mixins: [mixins],
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
        this.$store.dispatch('removeDocument', payload).then(() => flash({
          message: "Le document a bien été supprimé.",
          level: 'success'
        })).catch(() => flash({
          message: "Il y a eu un problème lors de la suppression du document.",
          level: 'danger'
        }))
      },
      /**
       * Add a new contact.
       */
      addContact(contact) {
        this.$store.dispatch('addContact', contact).then(() => flash({
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
        axios.post(route('orders.validation', [this.order.reference]), this.order).then(() => {
          this.errors = []
          this.$store.dispatch('toggleLoader')
          this.showPreview = true
          window.scroll({
            top: 0,
            left: 0,
            behavior: 'smooth'
          })
        }).catch(error => {
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
        axios.post(route('orders.validation', [this.order.reference]), this.order).then(() => {
          axios.patch(route('orders.complete', [this.order.reference]), this.order)
            .then(() => {
              flash({
                message: "Votre commande a bien été envoyée!",
                level: 'success'
              })
              setTimeout(() => {
                window.location = route('orders.index')
              }, 1000)
            }).catch(error => {
            console.log(error)
            this.$store.dispatch('toggleLoader')
          })
        }).catch(error => {
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
      eventBus.$on('removeDocument', document => {
        this.removeDocument(document)
      })
      /**
       * Set the selected business for the order.
       */
      if (this.order.business) {
        this.selectedBusiness = this.order.business.name
      }
      /**
       * Set the selected billing contact for the order.
       */
      if (this.order.contact) {
        this.selectedContact = this.order.contact.name
      }
      /**
       * Hydrate the store.
       */
      this.hydrateArticleTypes(this.articles)
      this.hydrateBusinesses(this.businesses)
      this.hydrateContacts(this.contacts)
      this.hydrateDeliveries(this.deliveries)
      this.hydrateDocuments(this.documents)
    },
    mounted() {
      /**
       * Add a delivery if none exist.
       */
      if (!this.listDeliveries.length) this.addDelivery()
    },
  }
</script>
