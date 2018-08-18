<template>
  <div class="modal__slider">
    <form
      class="modal__container"
      @submit.prevent="updateProfile">

      <AvatarUpload
        :avatar="avatar"
        :random-avatar="randomAvatar"/>

      <h2 class="modal__title">Mise à jour de votre <strong>compte</strong></h2>

      <!-- Username -->
      <ModalInput
        id="username"
        ref="focus"
        v-model="currentUser.username"
        type="text"
        required>
        <template slot="label">Nom d'utilisateur</template>
        <template
          v-if="errors.username"
          slot="errors">
          {{ errors.username[0] }}
        </template>
      </ModalInput>

      <!-- Email -->
      <ModalInput
        id="email"
        v-model="currentUser.email"
        type="email"
        required>
        <template slot="label">Adresse E-mail</template>
        <template
          v-if="errors.email"
          slot="errors">
          {{ errors.email[0] }}
        </template>
      </ModalInput>

      <!-- Password -->
      <ModalInput
        id="password"
        v-model="currentUser.password"
        type="password">
        <template slot="label">Mot de passe</template>
        <template
          v-if="errors.password"
          slot="errors">
          {{ errors.password[0] }}
        </template>
      </ModalInput>

      <!-- Password confirmation -->
      <ModalInput
        id="password_confirmation"
        v-model="currentUser.password_confirmation"
        type="password">
        <template slot="label">Mot de passe</template>
        <template
          v-if="errors.password_confirmation"
          slot="errors">
          {{ errors.password_confirmation[0] }}
        </template>
      </ModalInput>

      <!-- Controls -->
      <div class="modal__buttons">
        <button
          type="submit"
          role="button"
          class="button__primary button__primary--red button__primary--long">
          <i class="fal fa-check"/>
          Mettre à jour
        </button>
        <button
          role="button"
          class="button__primary button__primary--grey button__primary--long"
          @click.prevent="$emit('update-profile:close');">
          <i class="fal fa-times"/>
          Annuler
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import ModalInput from "../forms/ModalInput";
import AvatarUpload from "./AvatarUpload.vue";

import { mapActions } from "vuex";

export default {
  components: {
    ModalInput,
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
      currentUser: {
        id: this.user.id,
        username: this.user.username,
        email: this.user.email,
        password: "",
        password_confirmation: ""
      },
      errors: {}
    };
  },
  mounted() {
    this.$refs.focus.$el.children[2].focus();
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    async updateProfile() {
      this.toggleLoader();
      try {
        await window.axios.patch(
          window.route("account.update"),
          this.currentUser
        );
        this.$emit("profile:updated");
        this.$emit("update-profile:close");
        this.toggleLoader();
      } catch (err) {
        this.errors = err.response.data.errors;
        this.toggleLoader();
      }
    }
  }
};
</script>
