<template>
  <div>
    <div class="delivery__header delivery__header--preview">
      <div class="delivery__header-box delivery__header-box--white">
        <div class="delivery__details delivery__details--preview">
          <h3 class="delivery__label delivery__label--white">Livraison à</h3>
          <h3 class="delivery__info">{{ selectedContact | capitalize }}</h3>
        </div>
        <div class="delivery__details delivery__details--preview">
          <h3 class="delivery__label delivery__label--white">Livraison prévue le</h3>
          <h3 class="delivery__info">{{ toDeliverAt }}</h3>
        </div>
      </div>
      <div class="delivery__header-box delivery__header-box--white">
        <ul class="delivery__list">
          <li>{{ delivery.contact.address_line1 }}</li>
          <li>{{ delivery.contact.address_line2 }}</li>
          <li>{{ delivery.contact.zip }} {{ delivery.contact.city }}</li>
          <li>{{ delivery.contact.phone_number }}</li>
          <li>{{ delivery.contact.fax }}</li>
          <li>{{ delivery.contact.email }}</li>
        </ul>
      </div>
      <div class="delivery__delivery-note" v-if="delivery.note">
        <h5>Note</h5>
        {{ delivery.note }}
      </div>
    </div>

    <preview-document class="document__container document__container--preview"
                      v-for="(document, index) in deliveryDocuments"
                      :key="document.id"
                      :order="order"
                      :delivery="delivery"
                      :document="document"
                      :options="document.articles"></preview-document>
  </div>
</template>

<script>
  import PreviewDocument from './PreviewDocument.vue'
  import moment from 'moment'
  import mixins from '../../mixins'
  import { mapGetters } from 'vuex'

  export default {
    components: {
      PreviewDocument
    },
    props: {
      order: {
        type: Object,
        required: true
      },
      delivery: {
        type: Object,
        required: true
      },
      documents: {
        type: Array,
        required: true
      },
    },
    data() {
      return {
        selectedContact: 'Contact',
        showNote: false,
      }
    },
    mixins: [mixins],
    computed: {
      ...mapGetters([
        'listContacts',
        'listDeliveries'
      ]),
      toDeliverAt() {
        return moment(this.delivery.to_deliver_at).format('LL [à] HH[h]mm')
      },
      deliveryDocuments() {
        return this.documents.filter(document => {
          return document.delivery_id == this.delivery.id
        })
      },
    },
    created() {
      /**
       * Preselect the delivery's delivery dropdown contact.
       */
      if (this.delivery.contact) {
        this.selectedContact = this.delivery.contact.name
      }
    },
  }
</script>
