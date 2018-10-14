<template>
  <div
    :class="{ 'document__container--preview': preview }"
    class="document__container">

    <!-- File type icon -->
    <div class="document__image">
      <i
        :class="fileType"
        class="fal fa-5x icon__file-type"/>
    </div>

    <!-- Content -->
    <div class="document__content">

      <!-- File name -->
      <div class="document__header">
        <h2 class="document__title">{{ document.media[0].file_name }}</h2>
      </div>

      <div class="document__options-container">

        <div class="document__options-group">

          <!-- Print type -->
          <div class="document__option">
            <h4 class="document__option-label">Type d'impression</h4>
            <AppSelect
              :options="listArticlePrintTypes"
              v-model="currentDocument.printType"
              :disabled="preview"
              variant="printTypes"
              @input="updateArticle">
              {{ currentDocument.printType.label ? currentDocument.printType.label : 'Sélectionner' }}
            </AppSelect>
          </div>
          
          <!-- Finish -->
          <div class="document__option">
            <h4 class="document__option-label">Finition</h4>
            <AppSelect
              :options="optionsForFinish"
              v-model="currentDocument.finish"
              :disabled="preview"
              @input="update">
              {{ currentDocument.finish ? currentDocument.finish.label : 'Sélectionner' | capitalize }}
            </AppSelect>
          </div>
        </div>

        <div class="document__options-group">

          <!-- Options -->
          <div class="document__option">
            <h4 class="document__option-label">Options</h4>
            <AppSelect
              v-if="!preview"
              :disabled="preview"
              :options="listArticleOptionTypes"
              @input="addOption">
              Ajouter
            </AppSelect>
            <ul
              :class="{ 'document__list--disabled': preview }"
              class="document__list">
              <li
                v-for="option in currentDocument.options"
                :key="option.value"
                @click.prevent="removeOption(option)">
                <i class="fal fa-plus"/>
                <i class="fal fa-minus"/>
                <span>{{ option.label }}</span>
              </li>
            </ul>
          </div>

          <!--Quantity-->
          <div class="document__option">
            <h4 class="document__option-label">Quantité</h4>
            <input
              v-model.number="currentDocument.quantity"
              :disabled="preview"
              :class="{ 'document__input--disabled': preview }"
              type="number"
              class="document__input"
              @blur="checkQuantity">
          </div>
        </div>
      </div>

      <!-- Admin only controls -->
      <div
        v-if="admin"
        class="document__options-container">

        <div class="document__options-group">

          <!-- Format -->
          <div class="document__option">
            <h4 class="document__option-label">Format</h4>
            <AppSelect
              :options="listFormats"
              formats
              @input="selectFormat">
              Sélectionner
            </AppSelect>
          </div>

          <!-- Width -->
          <div class="document__option">
            <h4 class="document__option-label">Largeur</h4>
            <input
              v-model.number="currentDocument.width"
              type="number"
              class="document__input"
              @blur="update">
          </div>
        </div>

        <div class="document__options-group">

          <!-- Height -->
          <div class="document__option">
            <h4 class="document__option-label">Hauteur</h4>
            <input
              v-model.number="currentDocument.height"
              type="number"
              class="document__input"
              @blur="update">
          </div>
          
          <!-- Nb orig -->
          <div class="document__option">
            <h4 class="document__option-label">Pages</h4>
            <input
              v-model.number="currentDocument.nb_orig"
              type="number"
              class="document__input"
              @blur="update">
          </div>
        </div>
        
      </div>
    </div>

    <!-- Controls -->
    <div class="document__controls">

      <!-- Delete -->
      <Button
        :disabled="preview"
        :class="{ 'document__delete-button--disabled': preview }"
        title="Supprimer"
        class="document__delete-button"
        @click.prevent="destroy">
        <i class="fal fa-times"/>
      </Button>

      <!-- Copy -->
      <Button
        :disabled="preview"
        :class="{ 'document__copy-button--disabled': preview }"
        title="Caractéristiques à appliquer aux autres fichiers"
        class="document__copy-button"
        @click.prevent="copy">
        <i class="fal fa-copy"/>
      </Button>
    </div>
  </div>
</template>

<script>
import Button from "../buttons/Button";
import AppSelect from "../select/AppSelect";

import { filters } from "../../mixins";
import { eventBus } from "../../app";
import { mapGetters, mapActions } from "vuex";

export default {
  components: {
    Button,
    AppSelect
  },
  mixins: [filters],
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
      required: false,
      default() {
        return [];
      }
    },
    preview: {
      type: Boolean,
      required: false,
      default: false
    },
    admin: {
      type: Boolean,
      required: false,
      default: false
    }
  },
  data() {
    return {
      currentDocument: {
        id: this.document.id,
        article_id: this.document.article_id,
        delivery_id: this.document.delivery_id,
        quantity: this.document.quantity,
        media: this.document.media,
        width: this.document.width,
        height: this.document.height,
        nb_orig: this.document.nb_orig ? this.document.nb_orig : 1,
        printType: {
          label: "",
          type: "",
          greyscale: null,
          value: null
        },
        finish: {
          label: "",
          value: null
        },
        options: []
      },
      optionsForFinish: [
        { label: "plié", value: "plié" },
        { label: "roulé", value: "roulé" },
        { label: "à plat", value: "plat" }
      ],
      optionsForFormat: []
    };
  },
  computed: {
    ...mapGetters([
      "listFormats",
      "listDocuments",
      "listArticlePrintTypes",
      "listArticleOptionTypes"
    ]),
    fileType() {
      const mime_type = this.document.media[0].mime_type;
      if (this.fileTypeImage(mime_type)) {
        return "fa-file-image";
      } else if (this.fileTypePDF(mime_type)) {
        return "fa-file-pdf";
      } else if (this.fileTypeMSWord(mime_type)) {
        return "fa-file-word";
      } else if (this.fileTypeMSExcel(mime_type)) {
        return "fa-file-excel";
      } else if (this.fileTypeMSPowerPoint(mime_type)) {
        return "fa-file-powerpoint";
      } else {
        return "fa-file";
      }
    }
  },
  created() {
    this.copyDocumentDetails();
  },
  mounted() {
    this.findSelectedOptions();
    this.findSelectedPrintType();
    this.findSelectedFinish();
  },
  methods: {
    ...mapActions(["cloneOptions", "updateDocument", "deleteDocument"]),
    checkQuantity() {
      if (this.currentDocument.quantity <= 0) {
        this.currentDocument.quantity = 1;
      }
      this.update();
    },
    findSelectedFinish() {
      this.currentDocument.finish = this.optionsForFinish.find(option => {
        return option.value === this.document.finish;
      });
    },
    findSelectedOptions() {
      this.currentDocument.options = this.options.map(option => {
        return {
          value: option.id,
          label: option.description,
          type: option.type,
          greyscale: option.greyscale ? true : false
        };
      });
    },
    findSelectedPrintType() {
      if (this.document.article_id) {
        this.currentDocument.printType = this.listArticlePrintTypes.find(
          article => {
            return article.value === this.document.article_id;
          }
        );
      }
    },
    updateArticle() {
      this.currentDocument.article_id = this.currentDocument.printType.value;
      this.update();
    },
    async update() {
      await this.$store.dispatch("updateDocument", this.currentDocument);
    },
    async destroy() {
      await this.deleteDocument(this.currentDocument);
    },
    selectFormat(event) {
      this.currentDocument.width = event.value.width;
      this.currentDocument.height = event.value.height;
      this.update();
    },
    addOption(option) {
      const index = this.currentDocument.options.findIndex(item => {
        return item.value === option.value;
      });
      if (index === -1) {
        this.currentDocument.options.push(option);
        this.update();
      }
    },
    removeOption(option) {
      if (!this.preview) {
        this.currentDocument.options.splice(
          this.currentDocument.options.findIndex(item => {
            return item.value === option.value;
          }),
          1
        );
        this.update();
      }
    },
    copy() {
      eventBus.$emit("copy", {
        deliveryId: this.delivery.id,
        document: this.currentDocument
      });
    },
    copyDocumentDetails() {
      eventBus.$on("copy", payload => {
        const deliveryId = payload.deliveryId;
        const document = payload.document;

        if (
          deliveryId === this.delivery.id &&
          document.id !== this.document.id
        ) {
          this.currentDocument.printType = document.printType;
          this.currentDocument.article_id = document.printType.value;
          this.currentDocument.finish = document.finish;
          this.currentDocument.quantity = document.quantity;
          this.currentDocument.width = document.width;
          this.currentDocument.height = document.height;
          this.currentDocument.nb_orig = document.nb_orig;
          this.currentDocument.options = [];
          document.options.forEach(option => {
            const index = this.currentDocument.options.findIndex(item => {
              return item.value === option.value;
            });
            if (index === -1) {
              this.currentDocument.options.push(option);
            }
          });
          this.update();
        }
      });
    },
    fileTypeImage(mime_type) {
      return (
        mime_type === "image/jpeg" ||
        mime_type === "image/png" ||
        mime_type === "image/gif" ||
        mime_type === "image/vnd.adobe.photoshop" ||
        mime_type === "application/postscript"
      );
    },
    fileTypePDF(mime_type) {
      return mime_type === "application/pdf";
    },
    fileTypeMSWord(mime_type) {
      return (
        mime_type === "application/msword" ||
        mime_type ===
          "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
      );
    },
    fileTypeMSExcel(mime_type) {
      return (
        mime_type === "application/vnd.ms-excel" ||
        mime_type ===
          "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
      );
    },
    fileTypeMSPowerPoint(mime_type) {
      return (
        mime_type === "application/vnd.ms-powerpoint" ||
        mime_type ===
          "application/vnd.openxmlformats-officedocument.presentationml.presentation"
      );
    }
  }
};
</script>
