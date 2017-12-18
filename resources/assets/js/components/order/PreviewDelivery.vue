<template>
  <div>
    <div class="d-flex justify-content-between">

      <div class="d-flex align-items-start">
        <!--Contact-->
        <div class="d-flex align-items-top mt-2 mb-4">
          <h3 class="preview__label">Livraison à</h3>

          <!--Dropdown-->
          <app-dropdown :data="listContacts"
                        :add-contact-component="true"
                        @itemWasSelected="selectContact">
            <slot>
              <h3 class="preview-dropdown__label">
                {{ selectedContact | capitalize }}
              </h3>
            </slot>
          </app-dropdown>
        </div>
      </div>

      <div>
        <!--Datepicker-->
        <h3 class="delivery__date-label--white">Le</h3>
        <h3 class="delivery__date-label--white">{{ toDeliverAt }}</h3>
        <!--<app-datepicker :date="startTime"-->
                        <!--:option="option"-->
                        <!--:limit="limit"-->
                        <!--:to-deliver-at="delivery.to_deliver_at"-->
                        <!--@change="updateDeliveryDate">-->
        <!--</app-datepicker>-->
      </div>

      <div class="delivery__controls-container">
        <!--Delete delivery-->
        <div class="delivery__icon-destroy"
             v-if="listDeliveries.length > 1"
             @click="removeDelivery">
          <i class="fal fa-times"></i>
        </div>
      </div>
    </div>

    <!--Note-->
    <textarea class="v-order-textarea"
              placeholder="Faîtes nous part de vos commentaires pour cette livraison ici."
              @blur="updateNote"
              v-model="delivery.note"
              v-if="showNote"></textarea>

    <!--Document-->
    <transition-group name="order">
      <app-preview-document class="document__container"
                            v-for="(document, index) in deliveryDocuments"
                            :key="document.id"
                            :data-order="order"
                            :data-delivery="delivery"
                            :data-document="document"
                            :data-options="document.articles">
      </app-preview-document>
    </transition-group>
  </div>
</template>

<script>
  import AddContact from '../contact/AddContact.vue'
  import PreviewDocument from './PreviewDocument.vue'
  import moment from 'moment'
  import mixins from '../../mixins'
  import { mapGetters } from 'vuex'

  export default {
    props: [
      'data-order',
      'data-delivery',
      'data-delivery-number',
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
      'app-add-contact': AddContact,
      'app-preview-document': PreviewDocument
    },
    watch: {

      /**
       * Watch for changes in the deliveryDocuments computed property
       * and update the dropzone classes list.
       */
      deliveryDocuments() {
        this.determineDropzoneStyle()
      }
    },
    computed: {
      ...mapGetters([
        'listContacts',
        'listDeliveries'
      ]),

      toDeliverAt() {
        return moment(this.delivery.to_deliver_at).format('LL HH[h]mm')
      },

      /**
       * Filter the document models for the current delivery.
       */
      deliveryDocuments() {
        return this.documents.filter(document => {
          return document.delivery_id == this.delivery.id
        })
      },

      /**
       * Get the count of deliveries associated to the current order.
       */
      deliveryCount() {
        return this.dataDeliveryCount > 1 ? true : false
      }
    },
    methods: {
      /**
       * Select and update the delivery contact.
       */
      selectContact(contact) {
        this.selectedContact = contact.name
        this.delivery.contact_id = contact.id
        this.update()
      },

      /**
       * Update the delivery.
       */
      update() {
        axios.put(route('deliveries.update', [this.delivery.reference]), this.delivery)
      },

      /**
       * Delete a delivery.
       */
      removeDelivery() {
        this.$emit('removeDelivery', this.delivery)
      },

      /**
       * Toggle the visibility of the note textarea.
       */
      toggleNote() {
        this.showNote = !this.showNote
      },

      /**
       * Update the delivery note.
       */
      updateNote() {
        axios.put(route('deliveries.note.update', [this.delivery.reference]), this.delivery)
      },

      /**
       * Remove an existing note.
       */
      removeNote() {
        axios.delete(route('deliveries.note.destroy', [this.delivery.reference]), this.delivery)
        this.delivery.note = ''
        this.showNote = false
        flash({
          message: "La note a été supprimée.",
          level: 'success'
        })
      },

      /**
       * Update the delivery date.
       */
      updateDeliveryDate(date) {
        this.delivery.to_deliver_at = moment(date, "LL HH:mm").format("YYYY-MM-DD HH:mm:ss")
        this.update()
      },
    },
    created() {
      /**
       * Preselect the delivery's delivery dropdown contact.
       */
      if (this.dataDelivery.contact) {
        this.selectedContact = this.dataDelivery.contact.name
      }

      /**
       * Set the datepicker placeholder as the current to_deliver_at attribute.
       */
      if (this.delivery.to_deliver_at) {
        this.option.placeholder = moment(this.delivery.to_deliver_at).format('LL HH[h]mm')
      }

      /**
       * Set the visibility of the note textarea if it exists.
       */
      if (this.dataDelivery.note) {
        this.showNote = true
      }
    },
  }
</script>
