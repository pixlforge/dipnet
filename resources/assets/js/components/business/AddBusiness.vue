<template>
  <div>
    <button
      class="btn btn--red-large"
      role="button"
      @click="toggleModal">
      <i class="fal fa-plus-circle"/>
      Nouvelle affaire
    </button>

    <transition name="fade">
      <div
        v-if="showModal"
        class="modal__background"
        @click="toggleModal">$
      </div>
    </transition>

    <transition name="slide">
      <div
        v-if="showModal"
        class="modal__slider"
        @keyup.esc="toggleModal"
        @keyup.enter="addBusiness">

        <div class="modal__container">
          <h2 class="modal__title">Nouvelle affaire</h2>

          <div class="modal__group">
            <label
              for="name"
              class="modal__label">
              Nom
            </label>
            <span class="modal__required">*</span>
            <input
              id="name"
              v-model.trim="business.name"
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

          <div
            v-if="user.role === 'administrateur'"
            class="modal__group">
            <label
              for="reference"
              class="modal__label">
              Référence
            </label>
            <input
              id="reference"
              v-model.trim="business.reference"
              type="text"
              name="reference"
              class="modal__input"
              required>
            <div
              v-if="errors.reference"
              class="modal__alert">
              {{ errors.reference[0] }}
            </div>
          </div>

          <div class="modal__group">
            <label
              for="description"
              class="modal__label">
              Description
            </label>
            <input
              id="description"
              v-model.trim="business.description"
              type="text"
              name="description"
              class="modal__input"
              required>
            <div
              v-if="errors.description"
              class="modal__alert">
              {{ errors.description[0] }}
            </div>
          </div>

          <template v-if="userIsAdmin">
            <div class="modal__group">
              <label
                for="company_id"
                class="modal__label">
                Société
              </label>
              <span class="modal__required">*</span>
              <select
                id="company_id"
                v-model.number.trim="business.company_id"
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
          </template>

          <div class="modal__group">
            <label
              for="contact_id"
              class="modal__label">
              Contact
            </label>
            <span class="modal__required">*</span>
            <select
              id="contact_id"
              v-model.number="business.contact_id"
              name="contact_id"
              class="modal__select">
              <option disabled>Sélectionnez un contact</option>
              <option
                v-for="contact in filteredContacts"
                :key="contact.id"
                :value="contact.id">
                {{ contact.name }}
              </option>
            </select>
            <div
              v-if="errors.contact_id"
              class="modal__alert">
              {{ errors.contact_id[0] }}
            </div>
          </div>

          <div class="modal__group">
            <label
              for="folder_color"
              class="modal__label">
              Couleur
            </label>
            <select
              id="folder_color"
              v-model="business.folder_color"
              name="folder_color"
              class="modal__select">
              <option disabled>Sélectionner une couleur</option>
              <option value="red">Rouge</option>
              <option value="orange">Orange</option>
              <option value="purple">Violet</option>
              <option value="blue">Bleu</option>
            </select>
            <div
              v-if="errors.folder_color"
              class="modal__alert">
              {{ errors.folder_color[0] }}
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
              @click.prevent="addBusiness">
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
import { mapActions } from "vuex";

export default {
  mixins: [mixins],
  props: {
    companies: {
      type: Array,
      required: true
    },
    contacts: {
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
      business: {
        name: "",
        reference: "",
        description: "",
        company_id: "",
        contact_id: "",
        folder_color: ""
      },
      errors: {}
    };
  },
  computed: {
    filteredContacts() {
      if (this.userIsAdmin) {
        if (this.business.company_id !== "") {
          return this.contacts.filter(contact => {
            return contact.company_id === this.business.company_id;
          });
        }
      } else {
        return this.contacts;
      }
    },
    userIsAdmin() {
      return this.user.role === "administrateur";
    }
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    addBusiness() {
      this.$store.dispatch("toggleLoader");
      if (!this.userIsAdmin) {
        this.business.company_id = this.user.company.id;
      }
      window.axios
        .post(window.route("businesses.store"), this.business)
        .then(response => {
          this.business = response.data;
          this.$emit("businessWasCreated", this.business);
          this.$store.dispatch("toggleLoader");
          this.toggleModal();
          this.business = {};
          this.errors = {};
        })
        .catch(error => {
          this.$store.dispatch("toggleLoader");
          this.errors = error.response.data.errors;
        });
    }
  }
};
</script>
