<template>
  <div>
    <button
      class="btn btn--red-large"
      role="button"
      @click="toggleModal">
      <i class="fal fa-plus-circle"/>
      Nouveau contact
    </button>

    <transition name="fade">
      <div
        v-if="showModal"
        class="modal__background"
        @click="toggleModal"/>
    </transition>

    <transition name="slide">
      <div
        v-if="showModal"
        class="modal__slider"
        @keyup.esc="toggleModal"
        @keyup.enter="addContact">

        <div class="modal__container">
          <h2 class="modal__title">Nouveau contact</h2>

          <div class="modal__group">
            <label
              for="name"
              class="modal__label">
              Nom
            </label>
            <span class="modal__required">*</span>
            <input
              id="name"
              v-model.trim="contact.name"
              type="text"
              name="name"
              class="modal__input"
              required
              autofocus>
            <div
              v-if="errors.name"
              class="modal__alert">
              {{ errors.name[0] }}
            </div>
          </div>

          <div class="modal__group">
            <label
              for="address_line1"
              class="modal__label">
              Adresse ligne 1
            </label>
            <span class="modal__required">*</span>
            <input
              id="address_line1"
              v-model.trim="contact.address_line1"
              type="text"
              name="address_line1"
              class="modal__input"
              required>
            <div
              v-if="errors.address_line1"
              class="modal__alert">
              {{ errors.address_line1[0] }}
            </div>
          </div>

          <div class="modal__group">
            <label
              for="address_line2"
              class="modal__label">
              Adresse ligne 2
            </label>
            <input
              id="address_line2"
              v-model.trim="contact.address_line2"
              type="text"
              name="address_line2"
              class="modal__input">
            <div
              v-if="errors.address_line2"
              class="modal__alert">
              {{ errors.address_line2[0] }}
            </div>
          </div>

          <div class="modal__group">
            <label
              for="zip"
              class="modal__label">
              NPA
            </label>
            <span class="modal__required">*</span>
            <input
              id="zip"
              v-model="contact.zip"
              type="text"
              name="zip"
              class="modal__input"
              required>
            <div
              v-if="errors.zip"
              class="modal__alert">
              {{ errors.zip[0] }}
            </div>
          </div>

          <div class="modal__group">
            <label
              for="city"
              class="modal__label">
              Localité
            </label>
            <span class="modal__required">*</span>
            <input
              id="city"
              v-model.trim="contact.city"
              type="text"
              name="city"
              class="modal__input"
              required>
            <div
              v-if="errors.city"
              class="modal__alert">
              {{ errors.city[0] }}
            </div>
          </div>

          <div class="modal__group">
            <label
              for="phone_number"
              class="modal__label">
              Téléphone
            </label>
            <input
              id="phone_number"
              v-model.trim="contact.phone_number"
              type="text"
              name="phone_number"
              class="modal__input">
            <div
              v-if="errors.phone_number"
              class="modal__alert">
              {{ errors.phone_number[0] }}
            </div>
          </div>

          <div class="modal__group">
            <label 
              for="fax" 
              class="modal__label">
              Fax
            </label>
            <input
              id="fax"
              v-model.trim="contact.fax"
              type="text"
              name="fax"
              class="modal__input">
            <div
              v-if="errors.fax"
              class="modal__alert">
              {{ errors.fax[0] }}
            </div>
          </div>

          <div class="modal__group">
            <label
              for="email"
              class="modal__label">
              Email
            </label>
            <span class="modal__required">*</span>
            <input
              id="email"
              v-model.trim="contact.email"
              type="email"
              name="email"
              class="modal__input"
              required>
            <div
              v-if="errors.email"
              class="modal__alert">
              {{ errors.email[0] }}
            </div>
          </div>

          <div
            v-if="userIsAdmin"
            class="modal__group">
            <label
              for="company_id"
              class="modal__label">
              Société
            </label>
            <select
              id="company_id"
              v-model.number.trim="contact.company_id"
              name="company_id"
              class="modal__select">
              <option disabled>Sélectionnez une société</option>
              <option
                v-for="company in companies"
                :key="company.id"
                :value="company.id">
                {{ company.name }}
              </option>
            </select>
            <div
              v-if="errors.company_id"
              class="modal__alert">
              {{ errors.company_id[0] }}
            </div>
          </div>

          <div class="modal__buttons">
            <button
              class="btn btn--grey"
              role="button"
              @click.stop="toggleModal">
              <i class="fal fa-times"/>
              Annuler
            </button>
            <button
              class="btn btn--red"
              role="button"
              @click.prevent="addContact">
              <i class="fal fa-check"/>
              Ajouter
            </button>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import mixins from "../../mixins";
import { eventBus } from "../../app";
import { mapActions } from "vuex";

export default {
  mixins: [mixins],
  props: {
    companies: {
      type: Array,
      required: false,
      default: () => {
        return [];
      }
    },
    user: {
      type: Object,
      required: false,
      default: () => {
        return [];
      }
    }
  },
  data() {
    return {
      contact: {
        name: "",
        address_line1: "",
        address_line2: "",
        zip: "",
        city: "",
        phone_number: "",
        fax: "",
        email: "",
        company_id: null
      },
      errors: {}
    };
  },
  computed: {
    userIsAdmin() {
      return this.user.role === "administrateur";
    }
  },
  created() {
    eventBus.$on("dropdownAddContact", () => this.toggleModal());
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    addContact() {
      this.$store.dispatch("toggleLoader");
      window.axios
        .post(window.route("contacts.store"), this.contact)
        .then(response => {
          this.contact = response.data;
          this.$emit("contactWasCreated", this.contact);
          this.$store.dispatch("toggleLoader");
          this.toggleModal();
          this.contact = {};
        })
        .catch(error => {
          this.$store.dispatch("toggleLoader");
          this.errors = error.response.data.errors;
          this.redirectIfNotConfirmed(error);
        });
    }
  }
};
</script>
