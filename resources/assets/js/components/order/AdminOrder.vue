<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Commande {{ order.reference }}</h1>
      <div>
        <button class="btn btn--black"
                role="button"
                @click.prevent="switchOrderStatus">
          {{ order.status === 'envoyée' ? 'Marquer la commande traitée' : 'Marquer la commande envoyée' }}
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
      <admin-delivery class="delivery__container delivery__container--admin"
                      v-for="(delivery, index) in listDeliveries"
                      :key="delivery.id"
                      :order="order"
                      :delivery="delivery"
                      :documents="documents"
                      :formats="formats"></admin-delivery>
    </div>

    <moon-loader :loading="loaderState"
                 :color="loader.color"
                 :size="loader.size"></moon-loader>
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
    components: {
      AdminDelivery,
      AddContact,
      MoonLoader
    },
    props: {
      order: {
        type: Object,
        required: true
      },
      deliveries: {
        type: Array,
        required: true
      },
      articles: {
        type: Array,
        required: true
      },
      documents: {
        type: Array,
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
      formats: {
        type: Array,
        required: true
      }
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
    mixins: [mixins],
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
      switchOrderStatus() {
        if (this.order.status === 'envoyée') {
          this.order.status = 'traitée'
        } else if (this.order.status === 'traitée') {
          this.order.status = 'envoyée'
        }
        this.$store.dispatch('toggleLoader')
        axios.put(route('orders.status.update', [this.order.reference]), this.order).then(() => {
          this.$store.dispatch('toggleLoader')
          flash({
            message: `Le statut de la commande a été changé en ${this.order.status}`,
            level: 'success'
          })
        }).catch(() => {
          this.$store.dispatch('toggleLoader')
        })
      }
    },
    created() {
      this.hydrateArticleTypes(this.articles)
      this.hydrateBusinesses(this.businesses)
      this.hydrateContacts(this.contacts)
      this.hydrateDeliveries(this.deliveries)
      this.hydrateDocuments(this.documents)
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