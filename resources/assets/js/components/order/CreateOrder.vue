<template>
  <div>
    <transition
      name="fade"
      mode="out-in">

      <!--Preview-->
      <div
        v-if="showPreview"
        key="preview">
        <div class="header__container">
          <h1 class="header__title">Prévisualisation avant commande</h1>
          <div/>
        </div>
        <preview-delivery
          v-for="(delivery, index) in listDeliveries"
          :key="index"
          :class="'bg-red-' + (index + 1)"
          :order="order"
          :delivery="delivery"
          :delivery-number="index + 1"
          :documents="documents"
          class="delivery__container"
          @removeDelivery="removeDelivery"/>
        <div class="delivery__business">
          <h2>
            Associé à l'affaire
            <strong>{{ order.business.name | capitalize }}</strong>
          </h2>
          <ul class="delivery__list">
            <li>{{ order.business.name }}</li>
            <li>{{ order.business.reference }}</li>
          </ul>
        </div>
        <div class="delivery__billed-to">
          <h2>
            Facturation à
            <strong>{{ order.contact.name | capitalize }}</strong>
          </h2>
          <ul class="delivery__list">
            <li>{{ order.contact.name }}</li>
            <li>{{ order.contact.address_line1 }}</li>
            <li>{{ order.contact.address_line2 }}</li>
            <li>{{ order.contact.zip }} {{ order.contact.city }}</li>
            <li>{{ order.contact.phone_number }}</li>
            <li>{{ order.contact.fax }}</li>
            <li>{{ order.contact.email }}</li>
          </ul>
        </div>
        <div class="delivery__terms">
          <label>
            <input
              v-model="terms"
              type="checkbox">
            <div>
              J'ai lu et j'accepte les Conditions Générales de Vente (CGV)
            </div>
          </label>
        </div>
        <div class="delivery__terms-link">
          <p><a href="javascript:;">Conditions Générales de Vente</a></p>
        </div>
        <div class="order__footer">
          <button
            class="btn btn--grey"
            role="button"
            @click="goToOrder()">
            Retour
          </button>
          <button
            :disabled="!terms"
            class="btn btn--red"
            role="button"
            @click="completeOrder()">
            Commander
          </button>
        </div>
      </div>

      <!--Order-->
      <div
        v-else
        key="order">
        <div class="header__container">
          <h1 class="header__title">Nouvelle commande</h1>
          <div class="order__header">

            <!--Business-->
            <div class="order__business">
              <h6 class="order__label">Affaire</h6>
              <dropdown
                :label="selectedBusiness"
                :list-items="listBusinesses"
                @itemSelected="selectBusiness"/>
            </div>

            <!--Billing-->
            <div class="order__billing">
              <h6 class="order__label">Facturation</h6>
              <dropdown
                :label="selectedContact"
                :list-items="listContacts"
                :add-contact-component="true"
                @itemSelected="selectContact"/>
            </div>
          </div>

          <!--Add Contact-->
          <add-contact
            :user="user"
            class="v-hidden"
            @contactWasCreated="addContact"/>
        </div>

        <transition-group name="order">
          <create-delivery
            v-for="(delivery, index) in listDeliveries"
            :key="index"
            :order="order"
            :delivery="delivery"
            :delivery-number="index + 1"
            :documents="documents"
            class="delivery"
            @removeDelivery="removeDelivery"/>
        </transition-group>

        <div
          class="order__controls"
          role="button"
          @click="addDelivery">
          <h4 class="order__controls-label">
            <i class="fal fa-plus-circle mr-2"/>
            <span>Ajouter une livraison</span>
          </h4>
        </div>

        <div
          v-if="errors.length"
          class="order__errors">
          <i class="fal fa-exclamation-triangle"/>
          {{ errors[0].message }}
        </div>

        <div class="order__footer">
          <button
            class="btn btn--red"
            role="button"
            @click="goToPreview()">
            Aperçu de la commande
          </button>
        </div>

      </div>
    </transition>

    <moon-loader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import Dropdown from "../dropdown/Dropdown";
import PreviewDelivery from "./PreviewDelivery";
import CreateDelivery from "./CreateDelivery.vue";
import AddContact from "../contact/AddContact.vue";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";

import { eventBus } from "../../app";
import { loader } from "../../mixins";
import { mapActions, mapGetters } from "vuex";

export default {
  components: {
    CreateDelivery,
    PreviewDelivery,
    AddContact,
    Dropdown,
    MoonLoader
  },
  mixins: [loader],
  props: {
    order: {
      type: Object,
      required: true
    },
    businesses: {
      type: Array,
      required: true
    },
    contacts: {
      type: Array,
      required: true
    },
    deliveries: {
      type: Array,
      required: true
    },
    documents: {
      type: Array,
      required: true
    },
    articles: {
      type: Array,
      required: true
    },
    user: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      business: "Choisissez une affaire",
      selectedBusiness: "Affaire",
      selectedContact: "Contact",
      errors: [],
      showPreview: false,
      terms: false
    };
  },
  computed: {
    ...mapGetters([
      "loaderState",
      "listBusinesses",
      "listContacts",
      "listDeliveries",
      "listDocuments"
    ])
  },
  created() {
    /**
     * Delete a document.
     */
    eventBus.$on("removeDocument", document => {
      this.removeDocument(document);
    });
    /**
     * Set the selected business for the order.
     */
    if (this.order.business) {
      this.selectedBusiness = this.order.business.name;
    }
    /**
     * Set the selected billing contact for the order.
     */
    if (this.order.contact) {
      this.selectedContact = this.order.contact.name;
    }
    /**
     * Hydrate the store.
     */
    this.hydrateArticleTypes(this.articles);
    this.hydrateBusinesses(this.businesses);
    this.hydrateContacts(this.contacts);
    this.hydrateDeliveries(this.deliveries);
    this.hydrateDocuments(this.documents);
  },
  mounted() {
    /**
     * Add a delivery if none exist.
     */
    if (!this.listDeliveries.length) this.addDelivery();
  },
  methods: {
    ...mapActions([
      "toggleLoader",
      "hydrateArticleTypes",
      "hydrateBusinesses",
      "hydrateContacts",
      "hydrateDeliveries",
      "addDelivery",
      "hydrateDocuments",
      "removeDocument"
    ]),
    /**
     * Add a new delivery.
     */
    addDelivery() {
      this.$store
        .dispatch("addDelivery", this.order)
        .then(() =>
          window.flash({
            message: "Une nouvelle livraison a été ajoutée à votre commande.",
            level: "success"
          })
        )
        .catch(() =>
          window.flash({
            message:
              "Il y a eu un problème lors de la création de votre livraison.",
            level: "danger"
          })
        );
    },
    /**
     * Remove a delivery from the order.
     */
    removeDelivery(delivery) {
      this.$store
        .dispatch("removeDelivery", delivery)
        .then(() =>
          window.flash({
            message: "La livraison a bien été supprimée.",
            level: "success"
          })
        )
        .catch(() =>
          window.flash({
            message:
              "Il y a eu un problème lors de la suppression de la livraison.",
            level: "danger"
          })
        );
    },
    /**
     * Remove a document from a delivery.
     */
    removeDocument(payload) {
      this.$store
        .dispatch("removeDocument", payload)
        .then(() =>
          window.flash({
            message: "Le document a bien été supprimé.",
            level: "success"
          })
        )
        .catch(() =>
          window.flash({
            message:
              "Il y a eu un problème lors de la suppression du document.",
            level: "danger"
          })
        );
    },
    /**
     * Add a new contact.
     */
    addContact(contact) {
      this.$store.dispatch("addContact", contact).then(() =>
        window.flash({
          message: "La création du contact a réussi.",
          level: "success"
        })
      );
    },
    /**
     * Select a business using the dropdown component.
     */
    selectBusiness(business) {
      this.selectedBusiness = business.name;
      this.order.business_id = business.id;
      this.update();
    },
    /**
     * Select a contact using the dropdown component.
     */
    selectContact(contact) {
      this.selectedContact = contact.name;
      this.order.contact_id = contact.id;
      this.order.contact = contact;
      this.update();
    },
    /**
     * Update the order.
     */
    update() {
      window.axios
        .put(window.route("orders.update", [this.order.reference]), this.order)
        .catch(error => this.errors.push(error));
    },
    /**
     * Go to the preview order page.
     */
    goToPreview() {
      this.$store.dispatch("toggleLoader");
      window.axios
        .post(
          window.route("orders.validation", [this.order.reference]),
          this.order
        )
        .then(() => {
          this.errors = [];
          this.$store.dispatch("toggleLoader");
          this.showPreview = true;
          window.scroll({
            top: 0,
            left: 0,
            behavior: "smooth"
          });
        })
        .catch(error => {
          this.errors = [];
          this.errors.push(error.response.data);
          this.$store.dispatch("toggleLoader");
        });
    },
    /**
     * Go the the order page
     */
    goToOrder() {
      this.showPreview = false;
    },
    /**
     * Order
     */
    completeOrder() {
      this.$store.dispatch("toggleLoader");
      window.axios
        .post(
          window.route("orders.validation", [this.order.reference]),
          this.order
        )
        .then(() => {
          window.axios
            .patch(
              window.route("orders.complete", [this.order.reference]),
              this.order
            )
            .then(() => {
              window.flash({
                message: "Votre commande a bien été envoyée!",
                level: "success"
              });
              setTimeout(() => {
                window.location = window.route("orders.index");
              }, 1000);
            })
            .catch(() => {
              this.$store.dispatch("toggleLoader");
            });
        })
        .catch(error => {
          this.errors = [];
          this.errors.push(error.response.data);
          this.$store.dispatch("toggleLoader");
        });
    }
  }
};
</script>
