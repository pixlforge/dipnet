<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-10 my-5 mx-auto">
        <div class="row">
          <div class="order__container">
            <h1 class="order__title">Commande {{ order.reference }}</h1>
            <div class="order__header">
              <p>Ajouter un commentaire</p>
            </div>
            <div class="order__header">
              <p>Changer tous les status</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row bg-grey-light my-2">
      <div class="col-10 mx-auto my-6">
        <div class="my-3"
             v-for="(delivery, index) in listDeliveries"
             :key="delivery.id">
          <app-admin-delivery :data-order="order"
                              :data-delivery="delivery"
                              :data-documents="dataDocuments">
          </app-admin-delivery>
        </div>
      </div>
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
      'data-contacts'
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