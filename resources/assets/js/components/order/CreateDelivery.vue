<template>
  <div>
    <div class="delivery__header">
      <div class="delivery__header-box">
        <div class="delivery__details">
          <div class="badge badge-order"
               v-text="dataDeliveryNumber">
          </div>
          <h3 class="delivery__label">Livraison à</h3>
          <h3>
            <app-dropdown :label="selectedContact"
                          :list-items="listContacts"
                          add-contact-component="true"
                          @itemSelected="selectContact">
            </app-dropdown>
          </h3>
        </div>
      </div>
      <div class="delivery__header-box">
        <div class="delivery__details">
          <h3 class="delivery__label">Le</h3>
          <app-datepicker :date="startTime"
                          :option="option"
                          :limit="limit"
                          :to-deliver-at="delivery.to_deliver_at"
                          @change="updateDeliveryDate">
          </app-datepicker>
        </div>
      </div>
      <div class="delivery__controls">
        <div class="delivery__icon-destroy"
             v-if="listDeliveries.length > 1"
             @click="removeDelivery">
          <i class="fal fa-times"></i>
        </div>
        <p class="delivery__note-control"
           @click="removeNote"
           v-if="showNote">
          Retirer la note
        </p>
        <p class="delivery__note-control"
           @click="toggleNote"
           v-else>
          Ajouter une note
        </p>
      </div>
    </div>
    <transition name="fade">
      <textarea class="v-order-textarea"
                placeholder="Faîtes nous part de vos commentaires pour cette livraison ici."
                @blur="updateNote"
                v-model="delivery.note"
                v-if="showNote"></textarea>
    </transition>
    <transition-group name="order">
      <app-document class="document__container"
                    v-for="(document, index) in deliveryDocuments"
                    :key="document.id"
                    :data-order="order"
                    :data-delivery="delivery"
                    :data-document="document"
                    :data-options="document.articles">
      </app-document>
    </transition-group>
    <div :id="'delivery-file-upload-' + delivery.id" class="dropzone"></div>
  </div>
</template>

<script>
  import AddContact from '../contact/AddContact.vue'
  import Document from './Document.vue'
  import Dropzone from 'dropzone'
  import Datepicker from 'vue-datepicker'
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

        /**
         * Datepicker data. Moved to mixins, to delete.
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
            'background': '#f9f9f9',
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
      'app-add-contact': AddContact,
      'app-document': Document,
      'app-datepicker': Datepicker
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
        this.delivery.contact = contact
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

      /**
       * Determine the styles of the Dropzone container.
       */
      determineDropzoneStyle() {
        const templateHTML = document.getElementById('delivery-file-upload-' + this.delivery.id)

        if (this.deliveryDocuments.length) {
          templateHTML.classList.add('dropzone--small')
        } else {
          templateHTML.classList.remove('dropzone--small')
        }
      }
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
        this.option.placeholder = moment(this.delivery.to_deliver_at).format('LL [à] HH[h]mm')
      }

      /**
       * Set the visibility of the note textarea if it exists.
       */
      if (this.dataDelivery.note) {
        this.showNote = true
      }
    },
    mounted() {
      /**
       * Dropzone
       */
      Dropzone.autoDiscover = false

      let drop = new Dropzone('#delivery-file-upload-' + this.delivery.id, {
        createImageThumbnails: false,
        url: route('documents.store', [this.order.reference, this.delivery.reference]),
        headers: {
          'X-CSRF-TOKEN': window.Laravel.csrfToken
        },
        dictRemoveFile: "Supprimer",
        dictCancelUpload: "Annuler",
        dictDefaultMessage: "<span>Glissez-déposez des fichiers ici pour les télécharger ou</span> <span class='ml-3'><strong>choisissiez vos fichiers</strong>.</span>",
        dictFallbackMessage: "Votre navigateur est trop ancien ou incompatible. Changez-le ou mettez-le à jour.",
      })

      /**
       * Dropzone on successful file upload hook.
       */
      drop.on('success', (file, response) => {
        file.id = response.id
        this.$store.dispatch('addDocument', response)
        file.previewElement.classList.add("dz-hidden")
        flash({
          message: "Votre document a bien été téléchargé!",
          level: 'success'
        })
      })

      /**
       * Dropzone on removed file hook.
       */
      drop.on('removedfile', file => {
        axios.delete(route('documents.destroy', [this.order.reference, this.delivery.reference, file.id]))
          .catch(error => {
            drop.emit('addedfile', {
              id: file.id,
              name: file.name,
              size: file.size
            })
          })
      })

      this.determineDropzoneStyle()
    }
  }
</script>
