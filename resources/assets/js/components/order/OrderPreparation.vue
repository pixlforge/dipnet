<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Nouvelle commande</h1>
      <div class="order__header">

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
            @input="update">
            <p><strong>{{ currentOrder.contact.label ? currentOrder.contact.label : 'Aucun' }}</strong></p>
          </AppSelect>
        </div>

      </div>
    </div>

    <!-- Deliveries -->
    <Delivery
      v-for="(delivery, index) in listDeliveries"
      :key="delivery.id"
      :delivery="delivery"
      :order="order"
      :count="index + 1"/>

    <!-- <transition-group name="order">
      <create-delivery
        v-for="(delivery, index) in listDeliveries"
        :key="index"
        :order="order"
        :delivery="delivery"
        :delivery-number="index + 1"
        :documents="documents"
        class="delivery"
        @removeDelivery="removeDelivery"/>
    </transition-group> -->

    <!-- Add delivery button -->
    <div
      role="button"
      class="order__controls"
      @click.prevent="addDelivery">
      <h4 class="order__controls-label">
        <i class="fal fa-plus-circle mr-2"/>
        <span>Ajouter une livraison</span>
      </h4>
    </div>

    <!-- Preview button -->
    <div class="order__footer">
      <button
        role="button"
        class="btn btn--red"
        @click.prevent="preview">
        <i class="fal fa-search"/>
        Aperçu de la commande
      </button>
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
        @add-contact:close="closePanels"/>
    </transition>

    <MoonLoader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import Delivery from "./Delivery.vue";
import AppSelect from "../select/AppSelect";
import AddContact from "../contact/AddContact.vue";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";

import { mapActions, mapGetters } from "vuex";
import { loader, modal, panels } from "../../mixins";

export default {
  components: {
    Delivery,
    AppSelect,
    AddContact,
    MoonLoader
  },
  mixins: [loader, modal, panels],
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
      }
    };
  },
  computed: {
    ...mapGetters([
      "loaderState",
      "listDeliveries",
      "listContacts",
      "listBusinesses"
    ])
  },
  created() {
    this.hydrateContacts(this.contacts);
    this.hydrateDocuments(this.documents);
    this.hydrateBusinesses(this.businesses);
    this.hydrateDeliveries(this.deliveries);
    this.hydrateArticleTypes(this.articles);
  },
  mounted() {
    this.findSelectedBusiness();
    this.findSelectedContact();
    this.checkIfAtLeastOneDeliveryExists();
  },
  methods: {
    ...mapActions([
      "toggleLoader",
      "createDelivery",
      "hydrateContacts",
      "hydrateDocuments",
      "hydrateDeliveries",
      "hydrateBusinesses",
      "hydrateArticleTypes",
      "updateOrder"
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
    preview() {
      console.log("preview");
    }
  }
};
</script>

