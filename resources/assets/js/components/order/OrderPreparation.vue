<template>
  <div>
    <div class="header__container">

      <!-- Page title -->
      <h1 class="header__title">
        <template v-if="!preview">
          Nouvelle commande
        </template>
        <template v-else>
          Prévisualisation de la commande
        </template>
      </h1>

      <div
        v-if="!preview"
        class="order__header">
        
        <!-- Business -->
        <div class="order__business">
          <h6 class="order__label">Affaire</h6>
          <AppSelect
            :options="listBusinesses"
            v-model="currentOrder.business"
            @input="update">
            <p><strong>{{ currentOrder.business.label ? currentOrder.business.label : 'Aucune' }}</strong></p>
          </AppSelect>
        </div>

        <!-- Billing -->
        <div class="order__billing">
          <h6 class="order__label">Facturation</h6>
          <AppSelect
            :options="listContacts"
            v-model="currentOrder.contact"
            :component="{ component: 'order', id: order.id }"
            allow-create-contact
            @input="update">
            <p><strong>{{ currentOrder.contact.label ? currentOrder.contact.label : 'Aucun' }}</strong></p>
          </AppSelect>
        </div>
      </div>
    </div>

    <!-- Deliveries -->
    <transition name="fade">
      <div v-show="!animate">
        <Delivery
          v-for="(delivery, index) in listDeliveries"
          :key="delivery.id"
          :delivery="delivery"
          :order="order"
          :count="index + 1"
          :preview="preview"/>
      </div>
    </transition>

    <!-- Add delivery button -->
    <div
      v-if="!preview"
      role="button"
      class="order__controls"
      @click.prevent="addDelivery">
      <h4 class="order__controls-label">
        <i class="fal fa-plus-circle mr-2"/>
        <span>Ajouter une livraison</span>
      </h4>
    </div>

    <!-- Preview footer -->
    <transition name="fade">
      <div v-if="preview && !animate">

        <!-- Business recap -->
        <div
          v-if="getBusiness"
          class="delivery__business">
          <h2>
            Associé à l'affaire
            <strong>{{ getBusiness.name | capitalize }}</strong>
          </h2>
          <ul class="delivery__list">
            <li>Nom: <strong>{{ getBusiness.name }}</strong></li>
            <li>Référence: <strong>{{ getBusiness.reference }}</strong></li>
          </ul>
        </div>

        <!-- Billing recap -->
        <div
          v-if="getBillingContact"
          class="delivery__billed-to">
          <h2>
            Facturation à
            <strong>{{ getBillingContact.name | capitalize }}</strong>
          </h2>
          <ul class="delivery__list">
            <li>{{ getBillingContact.name }}</li>
            <li>{{ getBillingContact.address_line1 }}</li>
            <li>{{ getBillingContact.address_line2 }}</li>
            <li>{{ getBillingContact.zip }} {{ getBillingContact.city }}</li>
            <li>{{ getBillingContact.phone_number }}</li>
            <li>{{ getBillingContact.fax }}</li>
            <li>{{ getBillingContact.email }}</li>
          </ul>
        </div>

        <!-- Terms -->
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
        <div
          v-if="preview"
          class="delivery__terms-link">
          <p><a href="#">Conditions Générales de Vente</a></p>
        </div>
      </div>
    </transition>

    <div class="order__footer">
      <transition
        name="fade"
        mode="out-in">
        
        <!-- Complete button -->
        <button
          v-if="preview && !animate"
          :disabled="!terms"
          role="button"
          class="btn btn--red-big"
          @click.prevent="completeOrder">
          <i class="fal fa-paper-plane"/>
          Finaliser et envoyer la commande
        </button>
        
        <!-- Preview button -->
        <button
          v-if="!preview && !animate"
          role="button"
          class="btn btn--red"
          @click.prevent="togglePreview">
          <i class="fal fa-search"/>
          Aperçu de la commande
        </button>
      </transition>
    </div>

    <transition name="fade">
      <div
        v-if="showModal"
        class="modal__background"
        @click.prevent="closePanels"/>
    </transition>

    <!-- Add contact panel -->
    <transition name="slide">
      <AddContact
        v-if="showAddPanel"
        :component="componentToSelectContact"
        @add-contact:close="closePanels"/>
    </transition>

    <MoonLoader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import Delivery from "./Delivery";
import AppSelect from "../select/AppSelect";
import AddContact from "../contact/AddContact";
import MoonLoader from "vue-spinner/src/MoonLoader";

import VueScrollTo from "vue-scrollto";
import { eventBus } from "../../app";
import { mapActions, mapGetters } from "vuex";
import { loader, modal, panels, filters } from "../../mixins";

export default {
  components: {
    Delivery,
    AppSelect,
    AddContact,
    MoonLoader
  },
  mixins: [loader, modal, panels, filters],
  props: {
    articles: {
      type: Array,
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
    order: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      currentOrder: {
        id: this.order.id,
        reference: this.order.reference,
        status: this.order.status,
        user_id: this.order.user_id,
        business_id: this.order.business_id,
        contact_id: this.order.contact_id,
        manager_id: this.order.manager_id,
        business: {
          label: "",
          value: null
        },
        contact: {
          label: "",
          value: null
        }
      },
      preview: false,
      animate: false,
      terms: false,
      componentToSelectContact: {}
    };
  },
  computed: {
    ...mapGetters([
      "loaderState",
      "listContacts",
      "listDeliveries",
      "listBusinesses"
    ]),
    getBusiness() {
      return this.businesses.find(business => {
        return business.id === this.currentOrder.business.value;
      });
    },
    getBillingContact() {
      return this.contacts.find(contact => {
        return contact.id === this.currentOrder.contact.value;
      });
    }
  },
  created() {
    this.onContactCreated();
    this.bindAddContactHandler();
    this.hydrateContacts(this.contacts);
    this.hydrateDocuments(this.documents);
    this.hydrateBusinesses(this.businesses);
    this.hydrateDeliveries(this.deliveries);
    this.hydrateArticleTypes(this.articles);
  },
  mounted() {
    this.findSelectedContact();
    this.findSelectedBusiness();
    this.checkIfAtLeastOneDeliveryExists();
  },
  methods: {
    ...mapActions([
      "addContact",
      "updateOrder",
      "toggleLoader",
      "createDelivery",
      "hydrateContacts",
      "hydrateDocuments",
      "hydrateDeliveries",
      "hydrateBusinesses",
      "hydrateArticleTypes"
    ]),
    async addDelivery() {
      try {
        await this.createDelivery(this.order.reference);
        window.flash({
          message: "Une nouvelle livraison a été ajoutée à votre commande.",
          level: "success"
        });
      } catch (err) {
        window.flash({
          message:
            "Il y a eu un problème lors de la création de votre livraison.",
          level: "danger"
        });
      }
    },
    async update() {
      try {
        await this.updateOrder(this.currentOrder);
      } catch (err) {
        this.errors = err.response.data.errors;
      }
    },
    findSelectedBusiness() {
      if (this.order.business_id) {
        this.currentOrder.business = this.listBusinesses.find(business => {
          return business.value === this.order.business_id;
        });
      }
    },
    findSelectedContact() {
      if (this.order.contact_id) {
        this.currentOrder.contact = this.listContacts.find(contact => {
          return contact.value === this.order.contact_id;
        });
      }
    },
    checkIfAtLeastOneDeliveryExists() {
      !this.listDeliveries.length ? this.addDelivery() : "";
    },
    togglePreview() {
      this.animate = true;
      setTimeout(() => {
        this.preview = !this.preview;
        this.animate = false;
        VueScrollTo.scrollTo("body");
      }, 200);
    },
    completeOrder() {
      this.togglePreview();
    },
    bindAddContactHandler() {
      eventBus.$on("add-contact:open", component => {
        this.openAddPanel();
        this.componentToSelectContact = component;
      });
    },
    onContactCreated() {
      eventBus.$on("contact:created", payload => {
        if (payload.component === "order") {
          this.addContact(payload.contact);
          this.currentOrder.contact = {
            label: payload.contact.name,
            value: payload.contact.id
          };
          this.currentOrder.contact_id = payload.contact.id;
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

