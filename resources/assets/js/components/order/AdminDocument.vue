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
          {{ currentDocument.filename }}
        </h2>
      </div>

      <div class="document__options-container">
        <div class="document__option">
          <h4 class="document__option-label">Format</h4>
          <format-dropdown
            :list-items="formats"
            label="Format"
            @itemSelected="selectFormat"/>
          <div class="document__size">
            <div class="document__size-group">
              <h4 class="document__option-label">Largeur</h4>
              <input
                v-model.number="listWidth"
                type="number"
                class="document__input"
                @blur="update()">
            </div>

            <div class="document__size-group">
              <h4 class="document__option-label">Hauteur</h4>
              <input
                v-model.number="listHeight"
                type="number"
                class="document__input"
                @blur="update()">
            </div>
          </div>
        </div>

        <div class="document__option">
          <h4 class="document__option-label">Type d'impression</h4>
          <article-dropdown
            :label="listSelectedPrintType"
            type="print"
            @itemSelected="selectPrintType"/>
        </div>

        <div class="document__option">
          <h4 class="document__option-label">Finition</h4>
          <article-dropdown
            :label="listSelectedFinish"
            type="finish"
            @itemSelected="selectFinish"/>
        </div>

        <div class="document__option">
          <h4 class="document__option-label">Options</h4>
          <article-dropdown
            label="Ajouter une option"
            type="option"
            @itemSelected="selectOption"/>
          <ul class="document__list">
            <li
              v-for="option in listSelectedOptions"
              :key="option.id"
              @click="removeOption(option.id)">
              <i class="fal fa-plus"/>
              <i class="fal fa-minus"/>
              <span>{{ option.description }}</span>
            </li>
          </ul>
        </div>

        <div class="document__option">
          <h4 class="document__option-label">Nb. Orig.</h4>
          <input
            v-model.number="currentDocument.nb_orig"
            type="number"
            class="document__input"
            @blur="update">
        </div>

        <div class="document__option">
          <h4 class="document__option-label">Quantité</h4>
          <input
            v-model.number="listSelectedQuantity"
            type="number"
            class="document__input"
            @blur="update">
        </div>

      </div>
    </div>
    <div class="document__controls">
      <div
        class="document__icon-delete"
        title="Supprimer"
        role="button"
        @click="destroy">
        <i class="fal fa-times"/>
      </div>

      <div
        class="document__icon-clone"
        title="Copier"
        role="button"
        @click="clone">
        <i class="fal fa-copy"/>
      </div>
    </div>
  </div>
</template>

<script>
import ArticleDropdown from "./ArticleDropdown";
import FormatDropdown from "../dropdown/FormatDropdown";
import mixins from "../../mixins";
import { eventBus } from "../../app";
import { mapGetters } from "vuex";

export default {
  components: {
    ArticleDropdown,
    FormatDropdown
  },
  mixins: [mixins],
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
    },
    formats: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      currentOrder: this.order,
      currentDelivery: this.delivery,
      currentDocument: {
        id: this.document.id,
        filename: this.document.filename,
        mime_type: this.document.mime_type,
        size: this.document.size,
        quantity: this.document.quantity,
        finish: this.document.finish,
        delivery_id: this.document.delivery_id,
        article_id: "",
        options: [],
        width: this.document.width,
        height: this.document.height,
        nb_orig: this.document.nb_orig
      },
      selectedFinish: this.document.finish,
      selectedOptions: this.options
    };
  },
  computed: {
    ...mapGetters([
      "listArticlePrintTypes",
      "listArticleOptionTypes",
      "listDocuments"
    ]),
    listSelectedPrintType() {
      let label = {};
      if (this.document.article_id) {
        label = this.listArticlePrintTypes.find(article => {
          return article.id === this.document.article_id;
        });
      } else {
        label = {
          description: "Sélection",
          greyscale: null
        };
      }
      return label;
    },
    listSelectedFinish() {
      return this.listDocuments.find(document => {
        return document.id == this.currentDocument.id;
      }).finish;
    },
    listSelectedOptions() {
      return this.listDocuments.find(document => {
        return document.id == this.currentDocument.id;
      }).articles;
    },
    listSelectedQuantity: {
      get() {
        return this.listDocuments.find(document => {
          return document.id == this.currentDocument.id;
        }).quantity;
      },
      set(newValue) {
        if (newValue < 1) {
          this.currentDocument.quantity = 1;
        } else {
          this.currentDocument.quantity = newValue;
        }
      }
    },
    listWidth: {
      get() {
        return this.listDocuments.find(document => {
          return document.id == this.currentDocument.id;
        }).width;
      },
      set(value) {
        this.currentDocument.width = value;
      }
    },
    listHeight: {
      get() {
        return this.listDocuments.find(document => {
          return document.id == this.currentDocument.id;
        }).height;
      },
      set(value) {
        this.currentDocument.height = value;
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
     * Fetch and copy cloned properties into this component's data.
     */
    eventBus.$on("clone", payload => {
      if (payload.deliveryId === this.currentDocument.delivery_id) {
        this.currentDocument.article_id = payload.article_id;
        this.selectedPrintType = payload.selectedPrintType;
        this.currentDocument.finish = payload.finish;
        this.currentDocument.quantity = payload.quantity;
        this.currentDocument.options = payload.options;
        this.selectedOptions = payload.optionModels;
      }
    });
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
      this.currentDocument.article_id = this.document.article_id;
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
    clone() {
      this.$store
        .dispatch("cloneOptions", {
          orderReference: this.currentOrder.reference,
          deliveryReference: this.currentDelivery.reference,
          deliveryId: this.currentDelivery.id,
          print: this.currentDocument.article_id,
          selectedPrintType: this.selectedPrintType,
          finish: this.currentDocument.finish,
          quantity: this.currentDocument.quantity,
          options: this.currentDocument.options,
          optionModels: this.selectedOptions,
          width: this.currentDocument.width,
          height: this.document.height
        })
        .then(() => {
          eventBus.$emit("clone", {
            deliveryId: this.currentDelivery.id,
            article_id: this.currentDocument.article_id,
            selectedPrintType: this.selectedPrintType,
            finish: this.currentDocument.finish,
            quantity: this.currentDocumentcurrentDocument.quantity,
            options: this.currentDocument.options,
            optionModels: this.selectedOptions,
            width: this.currentDocument.width,
            height: this.currentDocument.height
          });
          window.flash({
            message:
              "Propriétés du document copiées à tous les autres documents de la livraison!",
            level: "success"
          });
        });
    },
    update() {
      this.$store.dispatch("updateDocument", {
        document: this.currentDocument,
        orderReference: this.currentOrder.reference,
        deliveryReference: this.currentDelivery.reference,
        options: this.selectedOptions
      });
    },
    destroy() {
      eventBus.$emit("removeDocument", {
        document: this.currentDocument,
        orderReference: this.currentOrder.reference,
        deliveryReference: this.currentDelivery.reference
      });
    },
    selectPrintType(type) {
      this.selectedPrintType = type.description;
      this.currentDocument.article_id = type.id;
      this.update();
    },
    selectFinish(finish) {
      this.selectedFinish = finish.name;
      this.currentDocument.finish = finish.name;
      this.update();
    },
    selectOption(newOption) {
      const index = this.selectedOptions.findIndex(option => {
        return option.id === newOption.id;
      });
      if (index === -1) {
        this.selectedOptions.unshift(newOption);
        this.currentDocument.options.push(newOption.id);
        this.update();
      }
    },
    selectFormat(format) {
      this.currentDocument.width = format.width;
      this.currentDocument.height = format.height;
      this.update();
    },
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
