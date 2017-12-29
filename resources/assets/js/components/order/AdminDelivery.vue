<template>
  <div class="delivery__container">
    <div class="delivery__content">
      <div class="delivery__header">
        <div class="delivery__row">
          <h5 class="delivery__label">
            Référence
            <strong>{{ delivery.reference }}</strong>
          </h5>
        </div>
        <div class="delivery__row">
          <h3 class="delivery__label">
            Livraison à
            <app-contact-dropdown class="delivery-contact-dropdown"
                                  :label="selectedDeliveryContact"
                                  @itemSelected="selectDeliveryContact">
            </app-contact-dropdown>
          </h3>
          <h3 class="delivery__label">
            Le
            <app-datepicker class="datepicker-light"
                            :date="startTime"
                            :option="option"
                            :limit="limit"
                            :to-deliver-at="delivery.to_deliver_at"
                            :style=""
                            @change="updateDeliveryDate">
            </app-datepicker>
          </h3>
        </div>
        <div class="delivery__row my-2">
          <ul class="delivery__contact-list">
            <li>{{ delivery.contact.address_line1 }}</li>
            <li>{{ delivery.contact.address_line2 }}</li>
            <li>{{ delivery.contact.zip }} {{ delivery.contact.city }}</li>
            <li>{{ delivery.contact.phone_number }}</li>
            <li>{{ delivery.contact.fax }}</li>
            <li>{{ delivery.contact.email }}</li>
          </ul>
          <div class="delivery__admin-note" v-if="delivery.note">
            <h5>Note</h5>
            <p>{{ delivery.note }}</p>
          </div>
        </div>
      </div>
      <app-admin-document class="document__admin"
                          v-for="(document, index) in deliveryDocuments"
                          :key="document.id"
                          :data-order="order"
                          :data-delivery="delivery"
                          :data-document="document"
                          :data-options="document.articles">
      </app-admin-document>
    </div>
    <div class="delivery__controls">
      <div class="delivery__status">
        <h5>Status</h5>
        <ul>
          <li>Réceptionnée</li>
          <li>Traitée</li>
          <li>Envoyée</li>
        </ul>
      </div>
      <div class="delivery__admin-note">
        <!--TODO-->
      </div>
      <button class="btn btn--black"
              @click="goToDeliveryNote()">
        Bulletin de livraison
      </button>
    </div>
  </div>
</template>

<script>
  import AdminDocument from './AdminDocument'
  import ContactDropdown from '../dropdown/ContactDropdown'
  import Datepicker from 'vue-datepicker'
  import moment from 'moment'
  import mixins from '../../mixins'
  import { eventBus } from '../../app'

  export default {
    props: [
      'data-order',
      'data-delivery',
      'data-documents'
    ],
    data() {
      return {
        order: this.dataOrder,
        delivery: this.dataDelivery,
        documents: this.dataDocuments,
        selectedDeliveryContact: this.dataDelivery.contact.name,

        /**
         * Datepicker data.
         */
        startTime: {
          time: ''
        },
        endTime: {
          time: ''
        },
        option: {
          type: 'min',
          week: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
          month: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
          format: 'LL [à] HH[h]mm',
          placeholder: 'Date de livraison',
          inputStyle: {
            'display': 'inline-block',
            'padding': '6px',
            'line-height': '22px',
            'font-size': '24px',
            'border': '0 solid #fff',
            'box-shadow': '0 0 0 0 rgba(0, 0, 0, 0.2)',
            'background': '#ffffff',
            'border-radius': '2px',
            'color': '#2b2b2b',
            'cursor': 'pointer'
          },
          color: {
            header: '#e84949',
            headerText: '#fff'
          },
          buttons: {
            ok: 'Ok',
            cancel: 'Annuler'
          },
          overlayOpacity: 0.5,
          dismissible: true
        },
        timeoption: {
          type: 'min',
          week: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
          month: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
          format: 'LL HH:mm'
        },
        limit: [
          { type: 'weekday', available: [1, 2, 3, 4, 5] }
        ]
      }
    },
    mixins: [mixins],
    components: {
      'app-admin-document': AdminDocument,
      'app-contact-dropdown': ContactDropdown,
      'app-datepicker': Datepicker
    },
    computed: {
      /**
       * Filter the document models for the current delivery.
       */
      deliveryDocuments() {
        return this.documents.filter(document => {
          return document.delivery_id == this.delivery.id
        })
      },
    },
    methods: {
      /**
       * Update the delivery.
       */
      update() {
        axios.put(route('deliveries.update', [this.delivery.reference]), this.delivery)
      },

      /**
       * Update the delivery date.
       */
      updateDeliveryDate(date) {
        this.delivery.to_deliver_at = moment(date, "LL HH:mm").format("YYYY-MM-DD HH:mm:ss")
        this.update()
      },

      /**
       * Select the delivery contact.
       */
      selectDeliveryContact(contact) {
        console.log("selectDeliveryContact")
        this.selectedDeliveryContact = contact.name
        this.delivery.contact_id = contact.id
        this.delivery.contact = contact
        this.update()
      },

      /**
       * The link to the delivery's note
       */
      goToDeliveryNote() {
        console.log("Go to Delivery document")
      }
    },
    created() {
      /**
       * Set the datepicker placeholder as the current to_deliver_at attribute.
       */
      if (this.delivery.to_deliver_at) {
        this.option.placeholder = moment(this.delivery.to_deliver_at).format('LL [à] HH[h]mm')
      }
    }
  }
</script>