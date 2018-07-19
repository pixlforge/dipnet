<template>
  <div>
    <button
      class="btn btn--red-large"
      @click="toggleModal">
      <i class="fal fa-plus-circle"/>
      Nouvel utilisateur
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
        @keyup.enter="addUser">

        <div class="modal__container">
          <h2 class="modal__title">Nouvel utilisateur</h2>

          <div class="modal__group">
            <label
              for="username"
              class="modal__label">
              Nom d'utilisateur
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
              Adresse Email
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
              Mot de passe
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
              Confirmation
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

          <div class="modal__group">
            <label
              for="role"
              class="modal__label">
              Rôle
            </label>
            <span class="modal__required">*</span>
            <select
              id="role"
              v-model.trim="user.role"
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
              v-model.number.trim="user.company_id"
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
              @click.prevent="addUser">
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

export default {
  mixins: [mixins],
  props: {
    companies: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      user: {
        username: "",
        password: "",
        role: "",
        email: "",
        company_id: ""
      },
      errors: {}
    };
  },
  computed: {
    userIsNotAdmin() {
      return this.user.role === "" || this.user.role === "utilisateur";
    }
  },
  methods: {
    addUser() {
      if (this.user.role === "administrateur") {
        this.user.company_id = null;
      }
      this.$store.dispatch("toggleLoader");
      window.axios
        .post(window.route("admin.users.store"), this.user)
        .then(response => {
          this.user = response.data;
          this.$emit("userWasCreated", this.user);
          this.$store.dispatch("toggleLoader");
          this.toggleModal();
          this.user = {};
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