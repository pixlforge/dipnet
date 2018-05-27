<template>
  <div
    title="Modifier"
    role="button">
    <div @click="toggleModal">
      <slot>
        <div>
          <i class="fal fa-pencil"/>
        </div>
      </slot>
    </div>

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
        @keyup.enter="updateBusiness">

        <div class="modal__container">
          <h2 class="modal__title">Modifier {{ business.name }}</h2>

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
            <span class="modal__required">*</span>
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
            <span class="modal__required">*</span>
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

          <div
            v-if="user.role === 'administrateur'"
            class="modal__group">
            <label
              for="company_id"
              class="modal__label">
              Société
            </label>
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

          <div class="modal__group">
            <label
              for="contact_id"
              class="modal__label">
              Contact
            </label>
            <select
              id="contact_id"
              v-model.number.trim="business.contact_id"
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
              @click.prevent="updateBusiness">
              <i class="fal fa-check"/>
              Mettre à jour
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
    business: {
      type: Object,
      required: true
    },
    companies: {
      type: Array,
      required: false,
      default: () => {
        return [];
      }
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
      errors: {}
    };
  },
  computed: {
    filteredContacts() {
      if (this.business.company_id !== "") {
        return this.contacts.filter(contact => {
          return contact.company_id === this.business.company_id;
        });
      }
    }
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    updateBusiness() {
      this.$store.dispatch("toggleLoader");
      window.axios
        .put(
          window.route("businesses.update", [this.business.id]),
          this.business
        )
        .then(() => {
          eventBus.$emit("businessWasUpdated", this.business);
        })
        .then(() => {
          this.$store.dispatch("toggleLoader");
          this.toggleModal();
        })
        .catch(error => {
          this.$store.dispatch("toggleLoader");
          this.errors = error.response.data;
        });
    }
  }
};
</script>
