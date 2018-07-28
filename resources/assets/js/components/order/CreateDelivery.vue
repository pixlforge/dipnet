<template>
  <div>
    <div class="delivery__header">
      <div class="delivery__header-box">
        <div class="delivery__details">
          <div
            class="badge__order"
            v-text="deliveryNumber"/>
          <h3 class="delivery__label">Livraison à</h3>
          <h3 class="delivery__label delivery__label--dropdown">
            <dropdown
              :label="selectedContact"
              :list-items="listContacts"
              :add-contact-component="true"
              @itemSelected="selectContact"/>
          </h3>
        </div>
      </div>
      <div class="delivery__header-box">
        <div class="delivery__details">
          <h3 class="delivery__label">Le</h3>
          <datepicker
            :date="startTime"
            :option="option"
            :limit="limit"
            :to-deliver-at="delivery.to_deliver_at"
            @change="updateDeliveryDate"/>
        </div>
      </div>
      <div class="delivery__controls">
        <div
          v-if="listDeliveries.length > 1"
          class="delivery__icon-destroy"
          role="button"
          @click="removeDelivery">
          <i class="fal fa-times"/>
        </div>
        <p
          v-if="showNote"
          class="delivery__note-control"
          role="button"
          @click="removeNote">
          Retirer la note
        </p>
        <p
          v-else
          class="delivery__note-control"
          role="button"
          @click="toggleNote">
          Ajouter une note
        </p>
      </div>
    </div>
    <transition name="fade">
      <textarea
        v-if="showNote"
        v-model="delivery.note"
        class="delivery__textarea"
        placeholder="Faîtes nous part de vos commentaires pour cette livraison ici."
        @blur="updateNote"/>
    </transition>
    <transition-group name="order">
      <document
        v-for="document in deliveryDocuments"
        :key="document.id"
        :order="order"
        :delivery="delivery"
        :document="document"
        :options="document.articles"
        class="document__container"/>
    </transition-group>
    <div
      :id="'delivery-file-upload-' + delivery.id"
      class="dropzone"/>
  </div>
</template>

<script>
import AddContact from "../contact/AddContact.vue";
import Document from "./Document.vue";
import Dropdown from "../dropdown/Dropdown";
import Datepicker from "vue-datepicker";

import Dropzone from "dropzone";
import moment from "moment";
import { mapGetters } from "vuex";

export default {
  components: {
    AddContact,
    Document,
    Dropdown,
    Datepicker
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
    deliveryNumber: {
      type: Number,
      required: true
    },
    documents: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      currentDocuments: [],
      selectedContact: "contact",
      showNote: false,

      /**
       * Datepicker data. Moved to mixins, to delete.
       */
      startTime: {
        time: ""
      },
      endTime: {
        time: ""
      },
      option: {
        type: "min",
        week: ["Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim"],
        month: [
          "Janvier",
          "Février",
          "Mars",
          "Avril",
          "Mai",
          "Juin",
          "Juillet",
          "Août",
          "Septembre",
          "Octobre",
          "Novembre",
          "Décembre"
        ],
        format: "LL [à] HH[h]mm",
        placeholder: "date de livraison",
        inputStyle: {
          display: "inline-block",
          padding: "6px",
          "line-height": "22px",
          "font-size": "24px",
          border: "0 solid #fff",
          "box-shadow": "0 0 0 0 rgba(0, 0, 0, 0.2)",
          background: "#f9f9f9",
          "border-radius": "2px",
          color: "#2b2b2b",
          cursor: "pointer"
        },
        color: {
          header: "#e84949",
          headerText: "#fff"
        },
        buttons: {
          ok: "Ok",
          cancel: "Annuler"
        },
        overlayOpacity: 0.5,
        dismissible: true
      },
      timeoption: {
        type: "min",
        week: ["Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim"],
        month: [
          "Janvier",
          "Février",
          "Mars",
          "Avril",
          "Mai",
          "Juin",
          "Juillet",
          "Août",
          "Septembre",
          "Octobre",
          "Novembre",
          "Décembre"
        ],
        format: "LL HH:mm"
      },
      limit: [{ type: "weekday", available: [1, 2, 3, 4, 5] }]
    };
  },
  computed: {
    ...mapGetters(["listContacts", "listDeliveries", "listDocuments"]),
    /**
     * Filter the document models for the current delivery.
     */
    deliveryDocuments() {
      return this.listDocuments.filter(document => {
        return document.delivery_id == this.delivery.id;
      });
    },
    /**
     * Get the count of deliveries associated to the current order.
     */
    deliveryCount() {
      return this.deliveryNumber > 1 ? true : false;
    }
  },
  watch: {
    /**
     * Watch for changes in the deliveryDocuments computed property
     * and update the dropzone classes list.
     */
    deliveryDocuments() {
      this.determineDropzoneStyle();
    }
  },
  created() {
    /**
     * Preselect the delivery's delivery dropdown contact.
     */
    if (this.delivery.contact) {
      this.selectedContact = this.delivery.contact.name;
    }
    /**
     * Set the datepicker placeholder as the current to_deliver_at attribute.
     */
    if (this.delivery.to_deliver_at) {
      this.option.placeholder = moment(this.delivery.to_deliver_at).format(
        "LL [à] HH[h]mm"
      );
    }
    /**
     * Set the visibility of the note textarea if it exists.
     */
    if (this.delivery.note) {
      this.showNote = true;
    }
  },
  mounted() {
    /**
     * Dropzone
     */
    Dropzone.autoDiscover = false;
    let drop = new Dropzone("#delivery-file-upload-" + this.delivery.id, {
      createImageThumbnails: false,
      url: window.route("documents.store", [
        this.order.reference,
        this.delivery.reference
      ]),
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
    /**
     * Dropzone on successful file upload hook.
     */
    drop.on("success", (file, response) => {
      file.id = response.id;
      this.$store.dispatch("addDocument", response);
      file.previewElement.classList.add("dz-hidden");
      window.flash({
        message: "Votre document a bien été téléchargé!",
        level: "success"
      });
    });
    /**
     * Dropzone on removed file hook.
     */
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
    this.determineDropzoneStyle();
  },
  methods: {
    /**
     * Select and update the delivery contact.
     */
    selectContact(contact) {
      this.selectedContact = contact.name;
      this.delivery.contact_id = contact.id;
      this.delivery.contact = contact;
      this.update();
    },
    /**
     * Update the delivery.
     */
    update() {
      window.axios.put(
        window.route("deliveries.update", [this.delivery.reference]),
        this.delivery
      );
    },
    /**
     * Delete a delivery.
     */
    removeDelivery() {
      this.$emit("removeDelivery", this.delivery);
    },
    /**
     * Toggle the visibility of the note textarea.
     */
    toggleNote() {
      this.showNote = !this.showNote;
    },
    /**
     * Update the delivery note.
     */
    updateNote() {
      window.axios.put(
        window.route("deliveries.note.update", [this.delivery.reference]),
        this.delivery
      );
    },
    /**
     * Remove an existing note.
     */
    removeNote() {
      window.axios
        .delete(
          window.route("deliveries.note.destroy", [this.delivery.reference]),
          this.delivery
        )
        .then(() => {
          this.delivery.note = "";
          this.showNote = false;
          window.flash({
            message: "La note a été supprimée.",
            level: "success"
          });
        });
    },
    /**
     * Update the delivery date.
     */
    updateDeliveryDate(date) {
      this.delivery.to_deliver_at = moment(date, "LL HH:mm").format(
        "YYYY-MM-DD HH:mm:ss"
      );
      this.update();
    },
    /**
     * Determine the styles of the Dropzone container.
     */
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
