<template>
  <div
    :class="previewContainerStyles"
    class="delivery__container">

    <!-- Header main -->
    <div class="delivery__header delivery__header--main">

      <!-- Contact -->
      <div class="delivery__header-box">
        <div class="delivery__details">

          <!-- Delivery number -->
          <div
            v-if="!preview"
            class="badge__order">
            {{ count }}
          </div>

          <!-- Contact label -->
          <h3
            :class="{ 'delivery__label--preview': preview }"
            class="delivery__label">
            Livraison à
          </h3>
          <h3
            v-if="preview"
            class="delivery__label delivery__label--bold delivery__label--preview">
            {{ currentDelivery.contact.label ? currentDelivery.contact.label : 'Sélectionner' }}
          </h3>

          <!-- Contact select -->
          <AppSelect
            v-else
            :options="listContacts"
            v-model="currentDelivery.contact"
            :component="{ component: 'delivery', id: delivery.id }"
            :user-is-solo="user.is_solo"
            large
            darker
            allow-pickup
            allow-create-contact
            @input="updateContact">
            <p>{{ currentDelivery.contact.label ? currentDelivery.contact.label : 'Sélectionner' }}</p>
          </AppSelect>
        </div>
      </div>

      <!-- Delivery mode -->
      <div class="delivery__header-box">
        <div class="delivery__details">
          <h3
            :class="{ 'delivery__label--preview': preview }"
            class="delivery__label">
            Mode de livraison
          </h3>
          <h3
            v-if="preview"
            class="delivery__label delivery__label--bold delivery__label--preview">
            {{ currentDelivery.deliveryMode.label ? currentDelivery.deliveryMode.label : 'Sélectionner' }}
          </h3>

          <AppSelect
            v-else
            :options="optionsForDeliveryMode"
            v-model="currentDelivery.deliveryMode"
            large
            darker
            @input="selectDeliveryMode">
            <p>{{ currentDelivery.deliveryMode.label ? currentDelivery.deliveryMode.label : 'Sélectionner' }}</p>
          </AppSelect>
        </div>
      </div>

      <!-- Datepicker -->
      <div
        v-show="currentDelivery.deliveryMode.value === 'date'"
        class="delivery__header-box">
        <div class="delivery__details">

          <!-- Datepicker label -->
          <h3
            :class="{ 'delivery__label--preview': preview }"
            class="delivery__label">
            Le
          </h3>
          <h3
            v-if="preview"
            class="delivery__label delivery__label--bold delivery__label--preview">
            {{ deliveryDateString }}
          </h3>

          <!-- Datepicker input -->
          <Datepicker
            v-else
            :date="startTime"
            :option="option"
            :limit="limit"
            :to-deliver-at="currentDelivery.to_deliver_at"
            @change="formatDeliveryDate"/>
        </div>
      </div>

      <!-- Controls -->
      <div class="delivery__controls">

        <!-- Remove note -->
        <Button
          v-if="showNote && !preview"
          class="delivery__note-control"
          @click.prevent="removeNote">
          Retirer la note
        </Button>

        <!-- Add note -->
        <Button
          v-if="!showNote && !preview"
          class="delivery__note-control"
          @click.prevent="toggleNote">
          Ajouter une note
        </Button>

        <!-- Delete delivery -->
        <Button
          v-if="listDeliveries.length > 1 && !preview"
          class="delivery__delete-button"
          @click.prevent="remove">
          <i class="fal fa-times"/>
        </Button>
      </div>
    </div>

    <!-- Header secondary -->
    <div class="delivery__header delivery__header--secondary">

      <!-- Selected contact details -->
      <div class="delivery__header-box">
        <div
          :class="{ 'delivery__details--order': !preview, 'delivery__details--preview': preview }"
          class="delivery__details">
          <ul
            v-if="selectedContactDetails"
            class="delivery__list">
            <li>{{ selectedContactDetails.name }}</li>
            <li>{{ selectedContactDetails.address_line1 }}</li>
            <li v-if="selectedContactDetails.address_line2">{{ selectedContactDetails.address_line2 }}</li>
            <li>{{ selectedContactDetails.zip }} {{ selectedContactDetails.city }}</li>
            <li v-if="selectedContactDetails.phone_number">{{ selectedContactDetails.phone_number }}</li>
            <li v-if="selectedContactDetails.fax">{{ selectedContactDetails.fax }}</li>
            <li>{{ selectedContactDetails.email }}</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Note -->
    <div v-if="!preview">
      <transition name="fade">
        <textarea
          v-if="showNote"
          v-model="currentDelivery.note"
          class="delivery__textarea"
          placeholder="Faîtes nous part de vos commentaires pour cette livraison ici."
          @blur="update"/>
      </transition>
    </div>

    <!-- Note preview -->
    <div
      v-if="currentDelivery.note && preview"
      class="delivery__note">
      <h5>Note:</h5>
      <p>{{ currentDelivery.note }}</p>
    </div>

    <!-- Documents -->
    <Document
      v-for="document in deliveryDocuments"
      :key="document.id"
      :order="order"
      :delivery="delivery"
      :document="document"
      :options="document.articles"
      :preview="preview"/>
    
    <!-- Dropzone -->
    <div
      v-show="!preview"
      :id="'delivery-file-upload-' + delivery.id"
      class="dropzone"/>

    <!-- Errors -->
    <div v-if="(!preview && hasErrors) || (!preview && hasErrorsRelatedToDocuments)">
      <div class="error__container">
        <i class="fas fa-exclamation fa-2x"/>
        <ul class="error__list">
          <li v-if="getValidationErrors[`deliveries.${count - 1}.contact_id`]">
            {{ getValidationErrors[`deliveries.${count - 1}.contact_id`][0] }}
          </li>
          <li v-if="getValidationErrors[`deliveries.${count - 1}.to_deliver_at`]">
            {{ getValidationErrors[`deliveries.${count - 1}.to_deliver_at`][0] }}
          </li>
          <li v-if="getValidationErrors[`deliveries.${count - 1}.documents`]">
            La livraison doit contenir au minimum un document.
          </li>
          <li v-if="hasErrorsRelatedToDocuments">
            Vous devez sélectionner un type d'impression pour chaque document de cette livraison.
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import Document from "./Document";
import Button from "../buttons/Button";
import AppSelect from "../select/AppSelect";
import Datepicker from "../datepicker/Datepicker";

import Dropzone from "dropzone";
import { eventBus } from "../../app";
import { datepicker } from "../../mixins";
import { mapGetters, mapActions } from "vuex";

export default {
  components: {
    Document,
    Button,
    AppSelect,
    Datepicker
  },
  mixins: [datepicker],
  props: {
    order: {
      type: Object,
      required: true
    },
    delivery: {
      type: Object,
      required: true
    },
    count: {
      type: Number,
      required: true
    },
    preview: {
      type: Boolean,
      required: false,
      default: false
    },
    user: {
      type: Object,
      required: false,
      default() {
        return {};
      }
    }
  },
  data() {
    return {
      currentDelivery: {
        id: this.delivery.id,
        reference: this.delivery.reference,
        note: this.delivery.note,
        admin_note: this.delivery.admin_note,
        to_deliver_at: this.delivery.to_deliver_at,
        order_id: this.delivery.order_id,
        contact_id: this.delivery.contact_id,
        contact: {
          label: "",
          value: null
        },
        pickup: this.delivery.pickup,
        express: this.delivery.express ? this.delivery.express : false,
        deliveryMode: {
          label: "",
          value: null
        }
      },
      errors: {},
      showNote: this.delivery.note ? true : false,
      deliveryDateString: "date à définir",
      optionsForDeliveryMode: [
        { label: "Sélection d'une date", value: "date" },
        { label: "Livraison éclair", value: "express" }
      ]
    };
  },
  computed: {
    ...mapGetters([
      "listContacts",
      "listRawContacts",
      "listDeliveries",
      "listDocuments",
      "getValidationErrors"
    ]),
    deliveryDocuments() {
      return this.listDocuments.filter(document => {
        return document.delivery_id === this.delivery.id;
      });
    },
    previewContainerStyles() {
      if (this.preview) {
        return `bg-red-${this.count}` + " delivery__container--preview";
      }
    },
    selectedContactDetails() {
      if (this.listRawContacts) {
        return this.listRawContacts.find(contact => {
          return contact.id === this.currentDelivery.contact.value;
        });
      }
    },
    hasErrors() {
      if (
        this.getValidationErrors[`deliveries.${this.count - 1}.contact_id`] ||
        this.getValidationErrors[
          `deliveries.${this.count - 1}.to_deliver_at`
        ] ||
        this.getValidationErrors[`deliveries.${this.count - 1}.documents`]
      ) {
        return true;
      }
    },
    hasErrorsRelatedToDocuments() {
      let hasErrors = false;
      for (let error in this.getValidationErrors) {
        if (error.includes(`deliveries.${this.count - 1}.documents.`)) {
          hasErrors = true;
        }
      }
      return hasErrors;
    }
  },
  watch: {
    listDocuments() {
      this.determineDropzoneStyle();
    }
  },
  created() {
    this.onContactCreated();
  },
  mounted() {
    this.initDropzone();
    this.determineDropzoneStyle();
    this.determineDeliveryMode();
    this.findSelectedContact();
    this.getSelectedDeliveryDate();
  },
  methods: {
    ...mapActions(["deleteDelivery", "addContact", "addDocument"]),
    updateContact() {
      if (this.currentDelivery.contact.value) {
        this.currentDelivery.contact_id = this.currentDelivery.contact.value;
        this.currentDelivery.pickup = false;
      } else {
        this.currentDelivery.pickup = true;
      }
      this.update();
    },
    async update() {
      try {
        await this.$store.dispatch("updateDelivery", this.currentDelivery);
      } catch (err) {
        this.errors = err.response.data.errors;
      }
    },
    async remove() {
      try {
        await this.deleteDelivery(this.currentDelivery);
      } catch (err) {
        this.errors = err.response.data.errors;
      }
    },
    toggleNote() {
      this.showNote = !this.showNote;
    },
    removeNote() {
      this.currentDelivery.note = "";
      this.update();
      this.showNote = false;
    },
    findSelectedContact() {
      if (this.delivery.contact_id) {
        this.currentDelivery.contact = this.listContacts.find(contact => {
          return contact.value === this.delivery.contact_id;
        });
      } else if (this.delivery.pickup) {
        this.currentDelivery.contact.label = "Récupérer sur place";
      }
    },
    initDropzone() {
      Dropzone.autoDiscover = false;

      const drop = new Dropzone("#delivery-file-upload-" + this.delivery.id, {
        createImageThumbnails: false,
        url: window.route("documents.store", [this.delivery.reference]),
        headers: {
          "X-CSRF-TOKEN": window.Laravel.csrfToken
        },
        maxFilesize: 10,
        addRemoveLinks: true,
        dictRemoveFile: "Supprimer",
        dictCancelUpload: "Annuler",
        dictCancelUploadConfirmation:
          "Êtes-vous certain de vouloir annuler le téléchargement?",
        dictDefaultMessage:
          "<span>Glissez-déposez des fichiers ici pour les télécharger ou</span> <span class='ml-3'><strong>choisissiez vos fichiers</strong>.</span>",
        dictFallbackMessage:
          "Votre navigateur est trop ancien ou incompatible. Changez-en ou mettez-le à jour.",
        dictFileTooBig:
          "Ce fichier est trop volumineux. {{filesize}}MB de {{maxFilesize}}MB autorisés.",
        dictFileSizeUnits: "mb"
      });

      drop.on("success", (file, res) => {
        this.addDocument(res);
        file.previewElement.classList.add("dz-hidden");
        window.flash({
          message: "Votre document a bien été téléchargé!",
          level: "success"
        });
      });
    },
    determineDropzoneStyle() {
      const templateHTML = document.getElementById(
        "delivery-file-upload-" + this.delivery.id
      );
      if (this.deliveryDocuments.length) {
        templateHTML.classList.add("dropzone--small");
      } else {
        templateHTML.classList.remove("dropzone--small");
      }
    },
    selectDeliveryMode(event) {
      if (event.value === "express") {
        this.currentDelivery.express = true;
        this.currentDelivery.to_deliver_at = null;
      } else if (event.value === "date") {
        this.currentDelivery.express = false;
      }
      this.update();
    },
    determineDeliveryMode() {
      if (this.delivery.express) {
        this.currentDelivery.deliveryMode = {
          label: this.optionsForDeliveryMode[1].label,
          value: this.optionsForDeliveryMode[1].value
        };
      } else if (!this.delivery.express) {
        this.currentDelivery.deliveryMode = {
          label: this.optionsForDeliveryMode[0].label,
          value: this.optionsForDeliveryMode[0].value
        };
      }
    },
    onContactCreated() {
      eventBus.$on("contact:created", payload => {
        if (
          payload.component === "delivery" &&
          payload.id === this.delivery.id
        ) {
          this.addContact(payload.contact);
          this.currentDelivery.contact = {
            label: payload.contact.name,
            value: payload.contact.id
          };
          this.currentDelivery.contact_id = payload.contact.id;
          this.update();
          window.flash({
            message: "Contact ajouté avec succès!",
            level: "success"
          });
        }
      });
    }
  }
};
</script>
