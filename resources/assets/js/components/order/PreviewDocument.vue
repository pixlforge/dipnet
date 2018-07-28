<template>
  <div>
    <div class="document__image">
      <i
        :class="fileType"
        class="fal fa-5x icon__file-type"/>
    </div>
    <div class="document__content">
      <div class="document__header">
        <h2 class="document__title">
          {{ document.filename }}
        </h2>
      </div>

      <div class="document__options-container">
        <div class="document__option">
          <h4 class="document__option-label">Type d'impression</h4>
          <p>{{ selectedPrintType }}</p>
        </div>

        <div class="document__option">
          <h4 class="document__option-label">Finition</h4>
          <p>{{ selectedFinish | capitalize }}</p>
        </div>

        <div class="document__option">
          <h4 class="document__option-label">Options</h4>
          <ul class="document__list document__list--preview">
            <li
              v-for="option in listSelectedOptions"
              :key="option.id">
              <i class="fal fa-plus"/>
              <span>{{ option.description }}</span>
            </li>
          </ul>
        </div>

        <div class="document__option">
          <h4 class="document__option-label">Quantité</h4>
          <p>{{ documentQuantity }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ArticleDropdown from "./ArticleDropdown";

import { eventBus } from "../../app";
import { mapGetters, mapActions } from "vuex";

export default {
  components: {
    ArticleDropdown
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
    document: {
      type: Object,
      required: true
    },
    options: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      currentDocument: {
        id: this.document.id,
        filename: this.document.filename,
        mime_type: this.document.mime_type,
        size: this.document.size,
        quantity: 1,
        finish: this.document.finish,
        delivery_id: this.document.delivery_id,
        article_id: "",
        options: []
      },
      selectedPrintType: "Sélection",
      selectedFinish: this.document.finish,
      selectedOptions: this.options,
      oldQuantity: 1
    };
  },
  computed: {
    ...mapGetters(["listArticlePrintTypes", "listArticleOptionTypes"]),
    listSelectedOptions() {
      const document = this.$store.getters.listDocuments.find(document => {
        return document.id == this.currentDocument.id;
      });
      return document.articles;
    },
    documentQuantity: {
      get() {
        return this.currentDocument.quantity;
      },
      set(newValue) {
        if (newValue < 1) {
          this.currentDocument.quantity = 1;
        } else {
          this.currentDocument.quantity = newValue;
        }
      }
    },
    fileType() {
      // Images
      if (
        this.currentDocument.mime_type === "image/jpeg" ||
        this.currentDocument.mime_type === "image/png" ||
        this.currentDocument.mime_type === "image/gif" ||
        this.currentDocument.mime_type === "image/vnd.adobe.photoshop" ||
        this.currentDocument.mime_type === "application/postscript"
      ) {
        return "fa-file-image";
      }
      // PDF
      if (this.currentDocument.mime_type === "application/pdf")
        return "fa-file-pdf";
      // Word
      if (
        this.currentDocument.mime_type === "application/msword" ||
        this.currentDocument.mime_type ===
          "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
      ) {
        return "fa-file-word";
      }
      // Excel
      if (
        this.currentDocument.mime_type === "application/vnd.ms-excel" ||
        this.currentDocument.mime_type ===
          "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
      ) {
        return "fa-file-excel";
      }
      // Powerpoint
      if (
        this.currentDocument.mime_type === "application/vnd.ms-powerpoint" ||
        this.currentDocument.mime_type ===
          "application/vnd.openxmlformats-officedocument.presentationml.presentation"
      ) {
        return "fa-file-powerpoint";
      }
      return "fa-file";
    }
  },
  created() {
    /**
     * Preselect the print type.
     */
    if (
      this.document.article_id !== null &&
      typeof this.document.article_id !== "undefined"
    ) {
      const label = this.listArticlePrintTypes.find(article => {
        return article.id === this.document.article_id;
      });
      this.selectedPrintType = label.description;
    } else {
      this.selectedPrintType = "Sélection";
    }
    /**
     * Preselect the quantity.
     */
    if (this.document.quantity > 1) {
      this.currentDocument.quantity = this.document.quantity;
    }
    /**
     * Populate the options array with the selected options.
     */
    if (typeof this.selectedOptions !== "undefined") {
      this.selectedOptions.forEach(option => {
        this.currentDocument.options.push(option.id);
      });
    }
  },
  methods: {
    ...mapActions(["cloneOptions"]),
    /**
     * Clone a document's option to all documents related to that delivery.
     */
    clone() {
      this.$store
        .dispatch("cloneOptions", {
          orderReference: this.order.reference,
          deliveryReference: this.delivery.reference,
          deliveryId: this.delivery.id,
          options: this.currentDocument.options,
          optionModels: this.selectedOptions
        })
        .then(() => {
          window.flash({
            message: "Options copiées à tous les documents de la livraison!",
            level: "success"
          });
        });
    },
    /**
     * Update a document's details
     */
    update() {
      this.oldQuantity = this.currentDocument.quantity;
      eventBus.$emit("updateDocument", {
        document: this.currentDocument,
        orderReference: this.order.reference,
        deliveryReference: this.delivery.reference,
        options: this.selectedOptions
      });
    },
    /**
     * Determine if the document's quantity should be updated.
     */
    updateQuantity() {
      if (this.oldQuantity !== this.currentDocument.quantity) this.update();
    },
    /**
     * Remove a document from the delivery.
     */
    destroy() {
      eventBus.$emit("removeDocument", {
        document: this.currentDocument,
        orderReference: this.order.reference,
        deliveryReference: this.delivery.reference
      });
    },
    /**
     * Set the selected print type from the dropdown.
     */
    selectPrintType(type) {
      this.selectedPrintType = type.description;
      this.currentDocument.article_id = type.id;
      this.update();
    },
    /**
     * Set the selected finish type from the dropdown.
     */
    selectFinish(finish) {
      this.selectedFinish = finish.name;
      this.currentDocument.finish = finish.name;
      this.update();
    },
    /**
     * Set the selected options from the dropdown.
     */
    selectOption(newOption) {
      const index = this.selectedOptions.findIndex(option => {
        return option.id === newOption.id;
      });
      if (index === -1) {
        this.selectedOptions.unshift(newOption);
        this.currentDocument.options.push(newOption.id);
        this.update();
      } else {
        this.update();
        return;
      }
    },
    /**
     * Remove an option.
     */
    removeOption(selectedOption) {
      this.selectedOptions.splice(
        this.selectedOptions.find(option => {
          return option.id === selectedOption.id;
        }),
        1
      );
      this.currentDocument.options.splice(
        this.currentDocument.options.findIndex(option => {
          return option === selectedOption.id;
        }),
        1
      );
      this.update();
    }
  }
};
</script>
