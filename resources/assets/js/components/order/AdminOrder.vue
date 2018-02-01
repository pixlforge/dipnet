<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Commande {{ order.reference }}</h1>
      <div>
        Statut de la commande
      </div>
      <div>
        <a class="btn btn--red-large"
           :href="routeOrderReceipt"
           target="_blank"
           rel="noopener noreferrer">
          <i class="fal fa-clipboard"></i>
          Bulletin de commande
        </a>
      </div>
    </div>

    <div class="order__container">
      <app-admin-delivery class="delivery__container delivery__container--admin"
                          v-for="(delivery, index) in listDeliveries"
                          :key="delivery.id"
                          :data-order="order"
                          :data-delivery="delivery"
                          :data-documents="dataDocuments"
                          :data-formats="dataFormats">
      </app-admin-delivery>
    </div>
  </div>
</template>

<script>
  import AdminDelivery from './AdminDelivery'
  import AddContact from '../contact/AddContact.vue'
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import mixins from '../../mixins'
  import { eventBus } from '../../app'
  import { mapActions, mapGetters } from 'vuex'

  export default {
    props: [
      'data-order',
      'data-deliveries',
      'data-articles',
      'data-documents',
      'data-businesses',
      'data-contacts',
      'data-formats'
    ],
    data() {
      return {
        order: this.dataOrder
      }
    },
    mixins: [mixins],
    components: {
      'app-admin-delivery': AdminDelivery,
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
      ]),

      routeOrderReceipt() {
        return route('orders.receipts.show', [this.order.reference])
      }
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
    },
    created() {
      /**
       * Hydrate the store.
       */
      this.hydrateArticleTypes(this.dataArticles)
      this.hydrateBusinesses(this.dataBusinesses)
      this.hydrateContacts(this.dataContacts)
      this.hydrateDeliveries(this.dataDeliveries)
      this.hydrateDocuments(this.dataDocuments)
    }
  }
</script>