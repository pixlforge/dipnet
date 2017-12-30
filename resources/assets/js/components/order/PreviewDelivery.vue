<template>
  <div>
    <div class="preview__header">
      <div class="preview__delivery-details">
        <div class="preview__details">
          <h3 class="preview__label">Livraison à</h3>
          <h3 class="preview__info">{{ selectedContact | capitalize }}</h3>
        </div>
        <div class="preview__details">
          <h3 class="preview__label">Livraison prévue le</h3>
          <h3 class="preview__info">{{ toDeliverAt }}</h3>
        </div>
      </div>
      <div class="preview__delivery-details">
        <ul class="preview__list">
          <li>{{ delivery.contact.address_line1 }}</li>
          <li>{{ delivery.contact.address_line2 }}</li>
          <li>{{ delivery.contact.zip }} {{ delivery.contact.city }}</li>
          <li>{{ delivery.contact.phone }}</li>
          <li>{{ delivery.contact.fax }}</li>
          <li>{{ delivery.contact.email }}</li>
        </ul>
      </div>
      <div class="preview__delivery-note" v-if="delivery.note">
        <h5>Note</h5>
        {{ delivery.note }}
      </div>
    </div>

    <!--Document-->
    <app-preview-document class="document__container document__container--preview"
                          v-for="(document, index) in deliveryDocuments"
                          :key="document.id"
                          :data-order="order"
                          :data-delivery="delivery"
                          :data-document="document"
                          :data-options="document.articles">
    </app-preview-document>
  </div>
</template>

<script>
  import PreviewDocument from './PreviewDocument.vue'
  import moment from 'moment'
  import mixins from '../../mixins'
  import { mapGetters } from 'vuex'

  export default {
    props: [
      'data-order',
      'data-delivery',
      'data-documents'
    ],
    data() {
      return {
        /**
         * Component data.
         */
        order: this.dataOrder,
        delivery: this.dataDelivery,
        documents: this.dataDocuments,
        articles: this.dataArticles,
        selectedContact: 'Contact',
        showNote: false,
      }
    },
    mixins: [mixins],
    components: {
      'app-preview-document': PreviewDocument
    },
    computed: {
      ...mapGetters([
        'listContacts',
        'listDeliveries'
      ]),

      toDeliverAt() {
        return moment(this.delivery.to_deliver_at).format('LL [à] HH[h]mm')
      },

      /**
       * Filter the document models for the current delivery.
       */
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
      if (this.dataDelivery.contact) {
        this.selectedContact = this.dataDelivery.contact.name
      }
    },
  }
</script>
