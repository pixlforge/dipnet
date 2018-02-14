<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Commande {{ order.reference }}</h1>
      <div>
          <button class="btn btn--black"
                  @click.prevent="switchOrderStatus">
            {{ this.order.status === 'envoyée' ? 'Marquer la commande traitée' : 'Marquer la commande envoyée' }}
          </button>
        <span v-show="order.status === 'envoyée'"><i class="fas fa-exclamation-circle text--warning"></i></span>
        <span v-show="order.status === 'traitée'"><i class="fas fa-check-circle text--success"></i></span>
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

    <app-moon-loader :loading="loaderState"
                     :color="loader.color"
                     :size="loader.size">
    </app-moon-loader>
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

      /**
       * Switch the status of the order.
       */
      switchOrderStatus() {
        if (this.order.status === 'envoyée') {
          this.order.status = 'traitée'
        } else if (this.order.status === 'traitée') {
          this.order.status = 'envoyée'
        }

        this.$store.dispatch('toggleLoader')

        axios.put(route('orders.status.update', [this.order.reference]), this.order)
          .then(() => {
            this.$store.dispatch('toggleLoader')
            flash({
              message: `Le statut de la commande a été changé en ${this.order.status}`,
              level: 'success'
            })
          })
          .catch(() => {
            this.$store.dispatch('toggleLoader')
          })
      }
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

<style scoped>
  .fa-exclamation-circle,
  .fa-check-circle {
    font-size: 4rem;
    margin-left: 2rem;
  }
</style>