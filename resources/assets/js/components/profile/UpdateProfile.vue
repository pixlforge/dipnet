<template>
  <div>
    <button
      class="btn btn--red"
      role="button"
      @click="toggleModal">
      <i class="fal fa-pencil"/>
      Éditer mon compte
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
        @keyup.enter="updateProfile">

        <div class="modal__container">

          <avatar-upload
            :avatar="avatar"
            :random-avatar="randomAvatar"/>

          <h2 class="modal__title">Mise à jour des informations du compte</h2>

          <div class="modal__group">
            <label
              for="username"
              class="modal__label">
              Nom
            </label>
            <span class="modal__required">*</span>
            <input
              id="username"
              v-model.trim="user.username"
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
              v-model.trim="user.email"
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

          <div class="modal__group">
            <label
              for="password"
              class="modal__label">
              Password
            </label>
            <span class="modal__required">*</span>
            <input
              id="password"
              v-model.trim="user.password"
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
              class="modal__label">
              Confirmation du mot de passe
            </label>
            <span class="modal__required">*</span>
            <input
              id="password_confirmation"
              v-model.trim="user.password_confirmation"
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
              @click.prevent="updateProfile">
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
import AvatarUpload from "./AvatarUpload.vue";

import { mapActions } from "vuex";

export default {
  components: {
    AvatarUpload
  },
  props: {
    user: {
      type: Object,
      required: true
    },
    avatar: {
      type: String,
      required: true
    },
    randomAvatar: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      errors: {}
    };
  },
  mounted() {
    this.user.password = null;
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    updateProfile() {
      this.toggleLoader();
      window.axios
        .patch(window.route("account.update"), this.user)
        .then(() => {
          this.toggleLoader();
          this.toggleModal();
          this.errors = {};
          this.user.password = "";
          this.user.password_confirmation = "";
          window.flash({
            message: "Votre compte a été mis à jour avec succès!",
            level: "success"
          });
        })
        .catch(err => {
          this.errors = err.response.data.errors;
          this.toggleLoader();
        });
    }
  }
};
</script>
