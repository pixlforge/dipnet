<template>
  <div>
    <div
      role="button"
      @click="toggleModal">
      <i class="fal fa-pencil"/>
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
        @keyup.enter="updateUser">

        <div class="modal__container">
          <h2 class="modal__title">Modifier {{ user.username }}</h2>

          <div class="modal__group">
            <label
              for="username"
              class="modal__label">
              Nom d'utilisateur
            </label>
            <span class="modal__required">*</span>
            <input
              id="username"
              v-model.trim="currentUser.username"
              type="text"
              name="username"
              class="modal__input"
              required
              autofocus>
            <div
              v-if="errors.username"
              class="modal__alert">
              {{ errors.username[0] }}
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
              v-model.trim="currentUser.email"
              type="email"
              name="email"
              class="modal__input"
              required
              autofocus>
            <div
              v-if="errors.email"
              class="modal__alert">
              {{ errors.email[0] }}
            </div>
          </div>

          <div class="modal__group">
            <label
              for="password"
              class="modal__label">
              Mot de passe
            </label>
            <span class="modal__required">*</span>
            <input
              id="password"
              v-model.trim="currentUser.password"
              type="password"
              name="password"
              class="modal__input"
              required>
            <div
              v-if="errors.password"
              class="modal__alert">
              {{ errors.password[0] }}
            </div>
          </div>

          <div class="modal__group">
            <label
              for="password_confirmation"
              class="modal__label">Confirmation</label>
            <span class="modal__required">*</span>
            <input
              id="password_confirmation"
              v-model.trim="currentUser.password_confirmation"
              type="password"
              name="password_confirmation"
              class="modal__input"
              required>
            <div
              v-if="errors.password_confirmation"
              class="modal__alert">
              {{ errors.password_confirmation[0] }}
            </div>
          </div>

          <div class="modal__group">
            <label
              for="role"
              class="modal__label">
              Rôle
            </label>
            <select
              id="role"
              v-model.trim="currentUser.role"
              name="role"
              class="modal__select">
              <option disabled>Sélectionnez un rôle</option>
              <option value="utilisateur">Utilisateur</option>
              <option value="administrateur">Administrateur</option>
            </select>
            <div
              v-if="errors.role"
              class="modal__alert">
              {{ errors.role[0] }}
            </div>
          </div>

          <div
            v-if="userIsNotAdmin"
            class="modal__group">
            <label
              for="company_id"
              class="modal__label">
              Société
            </label>
            <select
              id="company_id"
              v-model.trim="currentUser.company_id"
              name="company_id"
              class="modal__select">
              <option disabled>Sélectionnez une société</option>
              <option
                v-for="(company, index) in companies"
                :key="index"
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
              @click.prevent="updateUser">
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

export default {
  mixins: [mixins],
  props: {
    user: {
      type: Object,
      required: true
    },
    companies: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      currentUser: {
        id: this.user.id,
        username: this.user.username,
        email: this.user.email,
        password: null,
        password_confirmation: null,
        role: this.user.role,
        company_id: this.user.company_id
      },
      errors: {}
    };
  },
  computed: {
    userIsNotAdmin() {
      return (
        this.currentUser.role === "" || this.currentUser.role === "utilisateur"
      );
    }
  },
  methods: {
    updateUser() {
      this.$store.dispatch("toggleLoader");
      window.axios
        .put(
          window.route("users.update", [this.currentUser.id]),
          this.currentUser
        )
        .then(() => {
          eventBus.$emit("userWasUpdated", this.currentUser);
        })
        .then(() => {
          this.$store.dispatch("toggleLoader");
          this.toggleModal();
          this.currentUser.password = null;
          this.currentUser.password_confirmation = null;
        })
        .catch(() => {
          this.$store.dispatch("toggleLoader");
          this.currentUser.password = null;
          this.currentUser.password_confirmation = null;
        });
    }
  }
};
</script>
