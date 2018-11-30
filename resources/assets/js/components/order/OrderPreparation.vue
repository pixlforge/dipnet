<template>
  <div>
    <div class="header__container">

      <!-- Page title -->
      <h1 class="header__title">
        <template v-if="!preview && !admin">
          Nouvelle commande
        </template>
        <template v-if="preview">
          Prévisualisation de la commande
        </template>
        <template v-if="admin">
          Commande <strong>{{ order.reference }}</strong>
        </template>
      </h1>

      <!-- Order header -->
      <div
        v-if="!preview"
        class="order__header">
        
        <!-- Business -->
        <div class="order__business">
          <h6 class="order__label">Affaire</h6>
          <AppSelect
            :options="optionsForBusinesses"
            v-model="currentOrder.business"
            allow-create-business
            @input="updateBusiness">
            <p><strong>{{ currentOrder.business.label ? currentOrder.business.label : 'Aucune' }}</strong></p>
          </AppSelect>
        </div>

        <!-- Billing -->
        <div class="order__billing">
          <h6 class="order__label">Facturation</h6>
          <AppSelect
            :options="optionsForContact"
            v-model="currentOrder.contact"
            :component="{ component: 'order', id: order.id }"
            allow-create-contact
            @input="updateContact">
            <p><strong>{{ currentOrder.contact.label ? currentOrder.contact.label : 'Aucun' }}</strong></p>
          </AppSelect>
        </div>
      </div>
    </div>

    <!-- Admin order controls -->
    <div
      v-if="admin"
      class="header__container">

      <!-- Order status -->
      <div class="order__status">
        <div
          :class="statusClass"
          class="badge badge--larger badge--order-status">
          {{ currentOrder.status | capitalize }}
        </div>

        <div class="order__status-select">
          <h6 class="order__label">Statut</h6>
          <AppSelect
            :options="optionsForStatus"
            @input="updateStatus">
            <strong>{{ currentOrder.status ? currentOrder.status : 'Sélectionner' | capitalize }}</strong>
          </AppSelect>
        </div>
      </div>

      <!-- Header controls -->
      <div class="order__header-controls">

        <!-- Download -->
        <Button
          primary
          orange
          icon-only
          @click.prevent="download">
          <i class="fal fa-arrow-to-bottom fa-2x"/>
        </Button>

        <!-- Order receipt -->
        <a
          :href="routeOrderReceipt"
          role="button"
          class="button__primary button__primary--red button__primary--long"
          target="_blank"
          rel="noopener noreferrer">
          <i class="fal fa-clipboard"/>
          Bulletin de commande
        </a>
      </div>
    </div>

    <!-- Errors -->
    <div
      v-if="!preview && hasValidationErrors"
      class="header__container">
      <div class="error__container">
        <i class="fal fa-info-circle fa-2x"/>
        <ul class="error__list">
          <li v-if="hasValidationErrors">
            {{ getValidationErrors.contact_id[0] }}
          </li>
        </ul>
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
          :preview="preview"
          :user="user"
          :admin="admin"
          :contacts="contacts"/>
      </div>
    </transition>

    <!-- Add delivery button -->
    <div
      v-if="!preview && !animate && !admin"
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

    <!-- Order footer -->
    <div class="order__footer">
      <transition
        name="fade"
        mode="out-in">
        
        <div
          v-if="preview && !animate"
          class="order__button-group">

          <!-- Back button -->
          <Button
            primary
            big
            orange
            @click.prevent="togglePreview">
            <i class="fal fa-arrow-left"/>
            Modifier ma commande
          </Button>

          <!-- Complete button -->
          <Button
            :disabled="!terms"
            primary
            big
            red
            @click.prevent="complete">
            <i class="fal fa-paper-plane"/>
            Finaliser et envoyer la commande
          </Button>
        </div>
        
        <!-- Preview button -->
        <Button
          v-if="!preview && !animate && !admin"
          primary
          red
          long
          @click.prevent="togglePreview">
          <i class="fal fa-eye"/>
          Aperçu de la commande
        </Button>
      </transition>
    </div>

    <!-- Add contact panel -->
    <transition name="slide">
      <AddContact
        v-if="showAddPanel"
        :component="componentToSelectContact"
        @add-contact:close="closePanels"/>
    </transition>

    <!-- Add business panel -->
    <transition name="slide">
      <AddBusiness
        v-if="showAddBusinessPanel"
        :contacts="listContacts"
        :user="user"
        @add-business:close="closePanels"/>
    </transition>

    <!-- Modal backdrop -->
    <transition name="fade">
      <div
        v-if="showModal"
        class="modal__background"
        @click.prevent="closePanels"/>
    </transition>

    <!-- Spinner -->
    <MoonLoader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import Delivery from "./Delivery";
import Button from "../buttons/Button";
import AppSelect from "../select/AppSelect";
import AddContact from "../contact/AddContact";
import AddBusiness from "../business/AddBusiness";
import MoonLoader from "vue-spinner/src/MoonLoader";

import { eventBus } from "../../app";
import VueScrollTo from "vue-scrollto";
import { mapActions, mapGetters } from "vuex";
import { loader, modal, panels, filters } from "../../mixins";

export default {
  components: {
    Delivery,
    Button,
    AppSelect,
    AddContact,
    AddBusiness,
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
    formats: {
      type: Array,
      required: false,
      default() {
        return [];
      }
    },
    order: {
      type: Object,
      required: true
    },
    user: {
      type: Object,
      required: true
    },
    admin: {
      type: Boolean,
      required: false,
      default: false
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
      errors: {
        deliveries: {}
      },
      preview: false,
      animate: false,
      terms: false,
      componentToSelectContact: {},
      optionsForStatus: [
        { label: "Traitée", value: "traitée" },
        { label: "Envoyée", value: "envoyée" },
        { label: "Incomplète", value: "incomplète" }
      ]
    };
  },
  computed: {
    ...mapGetters([
      "loaderState",
      "listContacts",
      "listDocuments",
      "listDeliveries",
      "listBusinesses",
      "getValidationErrors"
    ]),
    statusClass() {
      if (this.currentOrder.status === "incomplète") return "badge--danger";
      if (this.currentOrder.status === "envoyée") return "badge--warning";
      if (this.currentOrder.status === "traitée") return "badge--success";
    },
    routeOrderReceipt() {
      return window.route("orders.receipts.show", [this.order.reference]);
    },
    getBusiness() {
      return this.businesses.find(business => {
        return business.id === this.currentOrder.business.value;
      });
    },
    getBillingContact() {
      return this.contacts.find(contact => {
        return contact.id === this.currentOrder.contact.value;
      });
    },
    hasValidationErrors() {
      if (this.getValidationErrors.contact_id) {
        return true;
      }
    },
    optionsForBusinesses() {
      let businesses;

      if (
        this.user.role === "administrateur" &&
        this.order.status !== "incomplète"
      ) {
        businesses = this.businesses.filter(business => {
          return business.company_id == this.order.company_id;
        });
      }

      if (this.user.role === "utilisateur" && !this.user.is_solo) {
        businesses = this.businesses.filter(business => {
          return business.company_id == this.user.company_id;
        });
      }

      if (this.user.role === "utilisateur" && this.user.is_solo) {
        businesses = this.businesses.filter(business => {
          return business.user_id == this.user.id;
        });
      }

      businesses = businesses.map(business => {
        return {
          label: business.name,
          value: business.id
        };
      });

      return businesses;
    },
    optionsForContact() {
      let contacts;

      if (
        this.user.role === "administrateur" &&
        this.order.status !== "incomplète"
      ) {
        contacts = this.contacts.filter(contact => {
          return contact.company_id == this.order.company_id;
        });
      }

      if (this.user.role === "utilisateur" && !this.user.is_solo) {
        contacts = this.contacts.filter(contact => {
          return contact.company_id == this.user.company_id;
        });
      }

      if (this.user.role === "utilisateur" && this.user.is_solo) {
        contacts = this.contacts.filter(contact => {
          return contact.user_id == this.user.id;
        });
      }

      contacts = contacts.map(contact => {
        return {
          label: this.contactName(contact),
          value: contact.id
        };
      });

      return contacts;
    }
  },
  created() {
    this.onContactCreated();
    this.onBusinessCreated();
    this.bindAddContactHandler();
    this.bindAddBusinessHandler();
    this.hydrateFormats(this.formats);
    this.hydrateContacts(this.contacts);
    this.hydrateDocuments(this.documents);
    this.hydrateDeliveries(this.deliveries);
    this.hydrateBusinesses(this.businesses);
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
      "addBusiness",
      "toggleLoader",
      "completeOrder",
      "createDelivery",
      "hydrateFormats",
      "hydrateContacts",
      "hydrateDocuments",
      "hydrateDeliveries",
      "hydrateBusinesses",
      "hydrateArticleTypes",
      "setValidationErrors"
    ]),
    async download() {
      let res = await window.axios.get(
        window.route("admin.orders.files.download", [this.order.reference]),
        { responseType: "blob" }
      );
      let blob = new Blob([res.data], { type: "application/x-zip" });
      let link = document.createElement("a");
      link.href = window.URL.createObjectURL(blob);
      link.download = `commande-${this.order.reference}-fichiers.zip`;
      link.click();
    },
    updateStatus(event) {
      this.currentOrder.status = event.value;
      this.update();
    },
    updateBusiness() {
      if (this.currentOrder.business.value) {
        this.currentOrder.business_id = this.currentOrder.business.value;
      }

      if (!this.user.is_solo) {
        const currentBusiness = this.businesses.find(business => {
          return business.id == this.currentOrder.business_id;
        });

        if (currentBusiness.contact_id) {
          const defaultContactForCurrentBusiness = this.contacts.find(
            contact => {
              return contact.id == currentBusiness.contact_id;
            }
          );

          this.currentOrder.contact.label = this.contactName(
            defaultContactForCurrentBusiness
          );
          this.currentOrder.contact.value = defaultContactForCurrentBusiness.id;
          this.currentOrder.contact_id = defaultContactForCurrentBusiness.id;
        }
      }

      this.update();
    },
    updateContact() {
      if (this.currentOrder.contact.value) {
        this.currentOrder.contact_id = this.currentOrder.contact.value;
      }
      this.update();
    },
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
        await this.$store.dispatch("updateOrder", this.currentOrder);
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
    buildOrder() {
      let order = {
        id: this.currentOrder.id,
        reference: this.currentOrder.reference,
        status: this.currentOrder.status,
        user_id: this.currentOrder.user_id,
        business_id: this.currentOrder.business_id,
        contact_id: this.currentOrder.contact_id,
        pickup: this.currentOrder.pickup,
        manager_id: this.currentOrder.manager_id,
        deliveries: this.listDeliveries
      };

      order.deliveries.forEach(delivery => {
        delivery.documents = this.listDocuments.filter(document => {
          return document.delivery_id === delivery.id;
        });
      });

      return order;
    },
    async complete() {
      if (this.terms) {
        let order = this.buildOrder();

        await this.completeOrder(order)
          .then(() => {
            window.flash({
              message: "Commande envoyée avec succès!",
              level: "success"
            });
            setTimeout(() => {
              window.location = "/";
            }, 1000);
          })
          .catch(err => {
            this.setValidationErrors(err.response.data.errors);
            this.togglePreview();
            this.terms = false;
            window.flash({
              message: `La commande comporte des erreurs.`,
              level: "warning"
            });
          });
      }
    },
    bindAddContactHandler() {
      eventBus.$on("add-contact:open", component => {
        this.openAddPanel();
        this.componentToSelectContact = component;
      });
    },
    bindAddBusinessHandler() {
      eventBus.$on("add-business:open", () => {
        this.openAddBusinessPanel();
      });
    },
    onBusinessCreated() {
      eventBus.$on("business:created", business => {
        this.addBusiness(business);
        this.currentOrder.business = {
          label: business.name,
          value: business.id
        };
        this.currentOrder.business_id = business.id;
        this.update();
        window.flash({
          message: "Affaire ajoutée avec succès!",
          level: "success"
        });
      });
    },
    onContactCreated() {
      eventBus.$on("contact:created", payload => {
        if (payload.component === "order") {
          this.addContact(payload.contact);
          this.currentOrder.contact = {
            label: this.contactName(payload.contact),
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
    },
    contactName(contact) {
      let fullName = contact.first_name;
      if (contact.last_name) {
        fullName += ` ${contact.last_name}`;
      }
      if (contact.company_name) {
        fullName += ` (${contact.company_name})`;
      }
      return fullName;
    }
  }
};
</script>

