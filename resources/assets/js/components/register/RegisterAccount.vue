<template>
  <div
    class="register__container"
    @keyup.enter="registerAccount">
    <section class="register__first-section">
      <div
        class="login__logo login__logo--color"
        aria-hidden="true">
        <img
          :src="logoColor"
          :alt="`${appName} logo`">
      </div>
      <div class="register__form">
        <h1 class="register__title">Création du compte</h1>

        <div class="form__group">
          <label for="username">Nom d'utilisateur</label>
          <span class="form__required">*</span>
          <input
            id="username"
            v-model.trim="account.username"
            type="text"
            name="username"
            class="form__input"
            required
            autofocus>
          <div
            v-if="errors.username"
            class="form__alert">
            {{ errors.username[0] }}
          </div>
        </div>

        <div class="form__group">
          <label for="email">Email</label>
          <span class="form__required">*</span>
          <input
            id="email"
            v-model.trim="account.email"
            type="email"
            name="email"
            class="form__input"
            required>
          <div
            v-if="errors.email"
            class="form__alert">
            {{ errors.email[0] }}
          </div>
        </div>

        <div class="form__group">
          <label for="password">Mot de passe</label>
          <span class="form__required">*</span>
          <input
            id="password"
            v-model.trim="account.password"
            type="password"
            name="password"
            class="form__input"
            required>
          <div
            v-if="errors.password"
            class="form__alert">
            {{ errors.password[0] }}
          </div>
        </div>

        <div class="form__group">
          <label for="password_confirmation">Mot de passe</label>
          <span class="form__required">*</span>
          <input
            id="password_confirmation"
            v-model.trim="account.password_confirmation"
            type="password"
            name="password_confirmation"
            class="form__input"
            required>
          <div
            v-if="errors.password_confirmation"
            class="form__alert">
            {{ errors.password_confirmation[0] }}
          </div>
        </div>

        <div class="register__buttons">
          <button
            class="btn btn--red"
            role="button"
            @click="registerAccount">
            <i class="fal fa-check"/>
            Créer le compte
          </button>
        </div>

        <div class="register__login">
          Vous disposez déjà d'un compte?
          <a
            :href="loginRoute"
            class="register__link">
            Connectez-vous
          </a>
        </div>
      </div>
    </section>

    <section class="login__second-section">
      <div
        class="login__logo login__logo--bw"
        aria-hidden="true">
        <img
          :src="logoBw"
          :alt="`${appName} logo`">
      </div>
      <carousel/>
    </section>
  </div>
</template>

<script>
import Carousel from "../carousel/Carousel";
import mixins from "../../mixins";

export default {
  components: {
    Carousel
  },
  mixins: [mixins],
  props: {
    registrationType: {
      type: String,
      required: true
    },
    invitation: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      account: {
        username: "",
        email: "",
        password: "",
        password_confirmation: "",
        is_solo: this.dataRegistrationType === "self" ? true : false
      },
      errors: {}
    };
  },
  created() {
    if (this.invitation) {
      this.account.email = this.invitation.email;
    }
  },
  methods: {
    /**
     * Register the account.
     */
    registerAccount() {
      this.$store.dispatch("toggleLoader");
      window.axios
        .post(window.route("register.store"), this.account)
        .then(() => {
          this.$store.dispatch("toggleLoader");
          this.account = {};
          this.$emit("accountCreated");
        })
        .catch(error => {
          this.$store.dispatch("toggleLoader");
          this.errors = error.response.data.errors;
        });
    }
  }
};
</script>
