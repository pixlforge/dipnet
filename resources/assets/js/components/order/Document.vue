<template>
  <div>
    <div class="document__image">
      <i class="fal fa-5x icon__file-type" :class="fileType"></i>
    </div>
    <div class="document__content">
      <div class="document__header">
        <h2 class="document__title">
          {{ document.filename }}
        </h2>
        <div class="document__icon-delete" @click="destroy">
          <i class="fal fa-times fa-2x"></i>
        </div>
      </div>

      <div class="document__options-container">
        <!--Print-->
        <div class="document__option">
          <h4 class="document__option-label">Type d'impression</h4>
          <app-article-dropdown type="print"
                                :label="selectedPrintType"
                                @itemSelected="selectPrintType">
          </app-article-dropdown>
        </div>

        <!--Finish-->
        <div class="document__option">
          <h4 class="document__option-label">Finition</h4>
          <app-article-dropdown type="finish"
                                :label="selectedFinish"
                                @itemSelected="selectFinish">
          </app-article-dropdown>
        </div>

        <!--Options-->
        <div class="document__option">
          <h4 class="document__option-label">Options</h4>
          <app-article-dropdown type="option"
                                label="Ajouter une option"
                                @itemSelected="selectOption">
          </app-article-dropdown>
          <ul class="document__list">
            <li v-for="(option, index) in selectedOptions"
                :key="option.id"
                @click="removeOption(index)">
              <i class="fal fa-plus"></i>
              <i class="fal fa-minus"></i>
              <span>{{ option.description }}</span>
            </li>
          </ul>
        </div>

        <!--Quantity-->
        <div class="document__option">
          <h4 class="document__option-label">Quantité</h4>
          <input type="number"
                 class="document__input"
                 v-model.number="documentQuantity"
                 @blur="updateQuantity()">
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import ArticleDropdown from './ArticleDropdown'
  import mixins from '../../mixins'
  import { eventBus } from '../../app'
  import { mapGetters } from 'vuex'

  export default {
    props: [
      'data-order',
      'data-delivery',
      'data-document',
    ],
    data() {
      return {
        order: this.dataOrder,
        delivery: this.dataDelivery,
        document: {
          id: this.dataDocument.id,
          filename: this.dataDocument.filename,
          mime_type: this.dataDocument.mime_type,
          size: this.dataDocument.size,
          quantity: 1,
          finish: '',
          delivery_id: this.dataDocument.delivery_id,
          article_id: '',
          options: []
        },
        selectedPrintType: 'Sélection',
        selectedFinish: 'Sélection',
        selectedOptions: [],
        oldQuantity: 1
      }
    },
    components: {
      'app-article-dropdown': ArticleDropdown
    },
    mixins: [mixins],
    computed: {
      ...mapGetters([
        'listArticlePrintTypes',
        'listArticleOptionTypes'
      ]),

      documentQuantity: {
        get() {
          return this.document.quantity
        },
        set(newValue) {
          if (newValue < 1) {
            this.document.quantity = 1
          } else {
            this.document.quantity = newValue
          }
        }
      },

      fileType() {

        /**
         * Images
         */
        if (this.document.mime_type === 'image/jpeg' ||
          this.document.mime_type === 'image/png' ||
          this.document.mime_type === 'image/gif' ||
          this.document.mime_type === 'image/vnd.adobe.photoshop' ||
          this.document.mime_type === 'application/postscript') {
          return 'fa-file-image'
        }

        /**
         * PDF
         */
        if (this.document.mime_type === 'application/pdf') return 'fa-file-pdf'

        /**
         * Word
         */
        if (this.document.mime_type === 'application/msword' || this.document.mime_type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
          return 'fa-file-word'
        }

        /**
         * Excel
         */
        if (this.document.mime_type === 'application/vnd.ms-excel' || this.document.mime_type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
          return 'fa-file-excel'
        }

        /**
         * Powerpoint
         */
        if (this.document.mime_type === 'application/vnd.ms-powerpoint' || this.document.mime_type === 'application/vnd.openxmlformats-officedocument.presentationml.presentation') {
          return 'fa-file-powerpoint'
        }

        return 'fa-file'
      }
    },
    methods: {
      /**
       * Update a document's details
       */
      update() {
        this.oldQuantity = this.document.quantity

        eventBus.$emit('updateDocument', {
          document: this.document,
          orderReference: this.order.reference,
          deliveryReference: this.delivery.reference
        })
      },

      /**
       * Determine if the document's quantity should be updated.
       */
      updateQuantity() {
        if (this.oldQuantity !== this.document.quantity) this.update()
      },

      /**
       * Remove a document from the delivery.
       */
      destroy() {
        eventBus.$emit('removeDocument', {
          document: this.document,
          orderReference: this.order.reference,
          deliveryReference: this.delivery.reference
        })
      },

      /**
       * Set the selected print type from the dropdown.
       */
      selectPrintType(type) {
        this.selectedPrintType = type.description
        this.document.article_id = type.id
        this.update()
      },

      /**
       * Set the selected finish type from the dropdown.
       */
      selectFinish(finish) {
        this.selectedFinish = finish.name
        this.document.finish = finish.name
        this.update()
      },

      /**
       * Set the selected options from the dropdown.
       */
      selectOption(newOption) {
        const index = this.selectedOptions.findIndex(option => {
          if (option.id === newOption.id) return true
        })

        if (index === -1) {
          this.selectedOptions.unshift(newOption)
          this.document.options.push(newOption)
          this.update()
        } else {
          this.update()
          return
        }
      },

      /**
       * Remove an option.
       */
      removeOption(index) {
        this.selectedOptions.splice(index, 1)
        this.update()
      },
    }
  }
</script>
