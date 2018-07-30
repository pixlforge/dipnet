<template>
  <div
    role="button"
    title="Modifier">
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

          <!-- Name -->
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

          <!-- Description -->
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

          <!-- User -->
          <template v-if="userIsAdmin">
            <div class="modal__group">
              <label
                for="user_id"
                class="modal__label">
                Utilisateur
              </label>
              <span class="modal__required">*</span>
              <select
                id="user_id"
                v-model.number.trim="business.user_id"
                name="user_id"
                class="modal__select"
                @input="business.company_id = ''">
                <option
                  v-for="user in users"
                  :key="user.id"
                  :value="user.id">
                  {{ user.username }}
                </option>
              </select>
              <div
                v-if="errors.user_id"
                class="modal__alert">
                {{ errors.user_id[0] }}
              </div>
            </div>
          </template>

          <!-- Société -->
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
              class="modal__select"
              @input="business.user_id = ''">
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

          <!-- Contact -->
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

          <!-- Folder Color -->
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
              role="button"
              class="btn btn--grey"
              @click.stop="toggleModal">
              <i class="fal fa-times"/>
              Annuler
            </button>
            <button
              role="button"
              class="btn btn--red"
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
import { mapActions } from "vuex";
import { eventBus } from "../../app";

export default {
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
    },
    users: {
      type: Array,
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
    },
    userIsAdmin() {
      return this.user.role === "administrateur";
    }
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    updateBusiness() {
      this.toggleLoader();
      window.axios
        .patch(
          window.route("admin.businesses.update", [this.business.id]),
          this.business
        )
        .then(() => {
          eventBus.$emit("business:updated", this.business);
          this.toggleLoader();
          this.toggleModal();
        })
        .catch(err => {
          this.errors = err.response.data;
          this.toggleLoader();
        });
    }
  }
};
</script>
