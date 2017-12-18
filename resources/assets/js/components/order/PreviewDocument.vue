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
            <li v-for="(option, index) in listSelectedOptions"
                :key="option.id"
                @click="removeOption(option.id)">
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
  import { mapGetters, mapActions } from 'vuex'

  export default {
    props: [
      'data-order',
      'data-delivery',
      'data-document',
      'data-options'
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
          finish: this.dataDocument.finish,
          delivery_id: this.dataDocument.delivery_id,
          article_id: '',
          options: []
        },
        selectedPrintType: 'Sélection',
        selectedFinish: this.dataDocument.finish,
        selectedOptions: this.dataOptions,
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
        'listArticleOptionTypes',
      ]),

      listSelectedOptions() {
        const document = this.$store.getters.listDocuments.find(document => {
          return document.id == this.document.id
        })
        return document.articles
      },

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
      ...mapActions([
        'cloneOptions'
      ]),

      /**
       * Clone a document's option to all documents related to that delivery.
       */
      clone() {
        this.$store.dispatch('cloneOptions', {
          orderReference: this.order.reference,
          deliveryReference: this.delivery.reference,
          deliveryId: this.delivery.id,
          options: this.document.options,
          optionModels: this.selectedOptions
        }).then(() => {
          flash({
            message: "Options copiées à tous les documents de la livraison!",
            level: 'success'
          })
        }).catch(error => console.log(error))
      },

      /**
       * Update a document's details
       */
      update(options = null) {
        this.oldQuantity = this.document.quantity

        eventBus.$emit('updateDocument', {
          document: this.document,
          orderReference: this.order.reference,
          deliveryReference: this.delivery.reference,
          options: this.selectedOptions
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
          return option.id === newOption.id
        })

        if (index === -1) {
          this.selectedOptions.unshift(newOption)
          this.document.options.push(newOption.id)
          this.update()
        } else {
          this.update()
          return
        }
      },

      /**
       * Remove an option.
       */
      removeOption(selectedOption) {
        this.selectedOptions.splice(this.selectedOptions.find(option => {
          return option.id === selectedOption.id
        }), 1)
        this.document.options.splice(this.document.options.findIndex(option => {
          return option => selectedOption.id
        }), 1)
        this.update()
      },
    },
    created() {
      /**
       * Preselect the print type.
       */
      if (this.dataDocument.article_id !== null &&
        typeof this.dataDocument.article_id !== 'undefined') {
        const label = this.listArticlePrintTypes.find(article => {
          return article.id === this.dataDocument.article_id
        })
        this.selectedPrintType = label.description
      } else {
        this.selectedPrintType = 'Sélection'
      }

      /**
       * Preselect the quantity.
       */
      if (this.dataDocument.quantity > 1) {
        this.document.quantity = this.dataDocument.quantity
      }

      /**
       * Populate the options array with the selected options.
       */
      if (typeof this.selectedOptions !== 'undefined') {
        this.selectedOptions.forEach(option => {
          this.document.options.push(option.id)
        })
      }
    },
  }
</script>
