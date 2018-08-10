<template>
  <div class="delivery__container">
    <div class="delivery__header">

      <!-- Contact -->
      <div class="delivery__header-box">
        <div class="delivery__details">
          <div class="badge__order">{{ count }}</div>
          <h3 class="delivery__label">Livraison à</h3>
          <AppSelect
            :options="listContacts"
            v-model="currentDelivery.contact"
            large
            darker
            @input="update">
            <p>{{ currentDelivery.contact.label ? currentDelivery.contact.label : 'Aucun' }}</p>
          </AppSelect>
        </div>
      </div>

      <!-- Datepicker -->
      <div class="delivery__header-box">
        <div class="delivery__details">
          <h3 class="delivery__label">Le</h3>
          <Datepicker
            :date="startTime"
            :option="option"
            :limit="limit"
            :to-deliver-at="currentDelivery.to_deliver_at"
            @change="formatDeliveryDate"/>
        </div>
      </div>

      <!-- Controls -->
      <div class="delivery__controls">

        <!-- Delete delivery -->
        <button
          v-if="listDeliveries.length > 1"
          role="button"
          class="delivery__delete-button"
          @click.prevent="remove">
          <i class="fal fa-times"/>
        </button>

        <!-- Remove note -->
        <button
          v-if="showNote"
          role="button"
          class="delivery__note-control"
          @click.prevent="removeNote">
          Retirer la note
        </button>

        <!-- Add note -->
        <button
          v-else
          role="button"
          class="delivery__note-control"
          @click.prevent="toggleNote">
          Ajouter une note
        </button>
      </div>
    </div>

    <!-- Note -->
    <transition name="fade">
      <textarea
        v-if="showNote"
        v-model="currentDelivery.note"
        class="delivery__textarea"
        placeholder="Faîtes nous part de vos commentaires pour cette livraison ici."
        @blur="update"/>
    </transition>

    <!-- Documents -->
    <Document
      v-for="document in deliveryDocuments"
      :key="document.id"
      :order="order"
      :delivery="delivery"
      :document="document"
      :options="document.articles"/>
    
    <!-- Dropzone -->
    <div
      :id="'delivery-file-upload-' + delivery.id"
      class="dropzone"/>
  </div>
</template>

<script>
import Document from "./Document";
import AppSelect from "../select/AppSelect";
import Datepicker from "../datepicker/Datepicker";

import Dropzone from "dropzone";
import { datepicker } from "../../mixins";
import { mapGetters, mapActions } from "vuex";

export default {
  components: {
    Document,
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
    }
  },
  data() {
    return {
      currentDelivery: {
        id: this.delivery.id,
        reference: this.delivery.reference,
        note: this.delivery.note,
        admin_note: this.delivery.admin_note,
        to_deliver_at: "",
        order_id: this.delivery.order_id,
        contact_id: this.delivery.contact_id,
        contact: {
          label: "",
          value: null
        }
      },
      errors: {},
      showNote: this.delivery.note ? true : false
    };
  },
  computed: {
    ...mapGetters(["listContacts", "listDeliveries", "listDocuments"]),
    deliveryDocuments() {
      return this.listDocuments.filter(document => {
        return document.delivery_id === this.delivery.id;
      });
    }
  },
  mounted() {
    this.initDropzone();
    this.findSelectedContact();
    this.determineDropzoneStyle();
    this.getSelectedDeliveryDate();
  },
  methods: {
    ...mapActions(["updateDelivery", "deleteDelivery"]),
    async update() {
      try {
        await this.updateDelivery(this.currentDelivery);
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
        dictRemoveFile: "Supprimer",
        dictCancelUpload: "Annuler",
        dictDefaultMessage:
          "<span>Glissez-déposez des fichiers ici pour les télécharger ou</span> <span class='ml-3'><strong>choisissiez vos fichiers</strong>.</span>",
        dictFallbackMessage:
          "Votre navigateur est trop ancien ou incompatible. Changez-le ou mettez-le à jour."
      });

      drop.on("success", (file, response) => {
        file.id = response.id;
        this.$store.dispatch("addDocument", response);
        file.previewElement.classList.add("dz-hidden");
        window.flash({
          message: "Votre document a bien été téléchargé!",
          level: "success"
        });
      });

      drop.on("removedfile", file => {
        window.axios
          .delete(
            window.route("documents.destroy", [
              this.order.reference,
              this.delivery.reference,
              file.id
            ])
          )
          .catch(() => {
            drop.emit("addedfile", {
              id: file.id,
              name: file.name,
              size: file.size
            });
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
    }
  }
};
</script>
