<template>
  <div>
    <div class="admin-delivery__header">
      <div class="admin-delivery__details">
        <h3 class="admin-delivery__reference">
          Réf. {{ delivery.reference }}
        </h3>

        <div class="admin-delivery__first-meta">
          <div class="admin-delivery__label-container">
            <h3 class="admin-delivery__label">Livraison à</h3>
            <h3 class="admin-delivery__label">
              <ContactDropdown
                :label="selectedDeliveryContact"
                :company-id="order.business.company_id"
                @item:selected="selectDeliveryContact"/>
            </h3>
          </div>
          <ul class="admin-delivery__contact-info">
            <li>{{ delivery.contact.address_line1 }}</li>
            <li>{{ delivery.contact.address_line2 }}</li>
            <li>{{ delivery.contact.zip }} {{ delivery.contact.city }}</li>
            <li>{{ delivery.contact.phone_number }}</li>
            <li>{{ delivery.contact.fax }}</li>
            <li>{{ delivery.contact.email }}</li>
          </ul>
        </div>

        <div class="admin-delivery__second-meta">
          <div class="admin-delivery__label-container">
            <h3 class="admin-delivery__label">Le</h3>
            <Datepicker
              :date="startTime"
              :option="option"
              :limit="limit"
              :to-deliver-at="delivery.to_deliver_at"
              class="datepicker-light"
              @change="updateDeliveryDate"/>
          </div>
          <div
            v-if="delivery.note"
            class="admin-delivery__note">
            <h5>Note</h5>
            {{ delivery.note }}
          </div>
        </div>
      </div>

      <div class="admin-delivery__controls">
        <a
          :href="routeDeliveryReceipt"
          role="button"
          class="btn btn--red"
          target="_blank"
          rel="noopener noreferrer">
          <i class="fal fa-clipboard"/>
          Bulletin de livraison
        </a>

        <textarea
          v-model="adminNote"
          type="text"
          class="form__textarea"
          placeholder="Commentaires pour admins"
          @blur="updateAdminNote"/>
      </div>
    </div>

    <div class="delivery__document-container">
      <AdminDocument
        v-for="document in deliveryDocuments"
        :key="document.id"
        :order="order"
        :delivery="delivery"
        :document="document"
        :options="document.articles"
        :formats="formats"
        class="document__admin"/>
    </div>
  </div>
</template>

<script>
import AdminDocument from "./AdminDocument";
import ContactDropdown from "../dropdown/ContactDropdown";
import Datepicker from "vue-datepicker";

import moment from "moment";

export default {
  components: {
    AdminDocument,
    ContactDropdown,
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
    documents: {
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
      selectedDeliveryContact: this.delivery.contact.name,
      adminNote: this.delivery.admin_note,
      /**
       * Datepicker data.
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
        placeholder: "Date de livraison",
        inputStyle: {
          display: "inline-block",
          padding: "6px",
          "line-height": "22px",
          "font-size": "24px",
          border: "0 solid #fff",
          "box-shadow": "0 0 0 0 rgba(0, 0, 0, 0.2)",
          background: "#ffffff",
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
    deliveryDocuments() {
      return this.documents.filter(document => {
        return document.delivery_id == this.delivery.id;
      });
    },
    routeDeliveryReceipt() {
      return window.route("deliveries.receipts.show", [
        this.delivery.reference
      ]);
    }
  },
  created() {
    /**
     * Set the datepicker placeholder as the current to_deliver_at attribute.
     */
    if (this.delivery.to_deliver_at) {
      this.option.placeholder = moment(this.delivery.to_deliver_at).format(
        "LL [à] HH[h]mm"
      );
    }
  },
  methods: {
    update() {
      window.axios.put(
        window.route("deliveries.update", [this.delivery.reference]),
        this.delivery
      );
    },
    updateAdminNote() {
      window.axios.patch(
        window.route("deliveries.admin.note.update", [this.delivery.reference]),
        {
          admin_note: this.adminNote
        }
      );
    },
    updateDeliveryDate(date) {
      this.delivery.to_deliver_at = moment(date, "LL HH:mm").format(
        "YYYY-MM-DD HH:mm:ss"
      );
      this.update();
    },
    selectDeliveryContact(contact) {
      this.selectedDeliveryContact = contact.name;
      this.delivery.contact_id = contact.id;
      this.delivery.contact = contact;
      this.update();
    }
  }
};
</script>