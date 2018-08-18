<template>
  <div
    class="register__container"
    @keyup.enter="createCompany">
    <section class="register__summary-section">
      <div
        class="register__logo register__logo--summary"
        aria-hidden="true">
        <img
          :src="logoBw"
          :alt="`${appName} logo`">
      </div>
      <div class="register__summary">
        <div class="register__summary-item register__summary-item--done">
          <span class="badge__summary"><i class="fa fa-check"/></span>
          <span class="register__summary-label">Création de votre compte</span>
        </div>

        <div class="register__summary-item register__summary-item--done">
          <span class="badge__summary">2</span>
          <span class="register__summary-label">Création de votre premier contact</span>
        </div>

        <div class="register__summary-item register__summary-item--active">
          <span class="badge__summary">3</span>
          <span class="register__summary-label">Création de votre société</span>
        </div>

        <div class="register__summary-item">
          <span class="badge__summary">4</span>
          <span class="register__summary-label">Terminé!</span>
        </div>
      </div>
    </section>

    <section class="register__form-section">
      <div class="register__form">
        <h1 class="register__title">Votre société</h1>

        <!-- Name -->
        <div class="form__group">
          <label for="name">Nom de la société</label>
          <span class="form__required">*</span>
          <input
            id="name"
            v-model.trim="company.name"
            type="text"
            name="name"
            class="form__input"
            required
            autofocus>
          <div
            v-if="errors.name"
            class="form__alert">
            {{ errors.name[0] }}
          </div>
        </div>

        <div class="register__buttons">
          <button
            role="button"
            class="button__primary button__primary--red button__primary--long"
            @click.prevent="createCompany">
            <i class="fal fa-check"/>
            Terminer l'enregistrement
          </button>
        </div>
      </div>
    </section>

    <MoonLoader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import MoonLoader from "vue-spinner/src/MoonLoader.vue";

import { mapGetters, mapActions } from "vuex";
import { appName, logo, loader } from "../../mixins";

export default {
  components: {
    MoonLoader
  },
  mixins: [appName, logo, loader],
  data() {
    return {
      company: {
        name: ""
      },
      errors: {}
    };
  },
  computed: {
    ...mapGetters(["loaderState"])
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    createCompany() {
      this.toggleLoader();
      window.axios
        .post(window.route("register.company.store"), this.company)
        .then(() => {
          this.company = {};
          window.flash({
            message: "Félicitations! Votre compte a bien été mis à jour!",
            level: "success"
          });
          setTimeout(() => {
            window.location = window.route("index");
          }, 1000);
        })
        .catch(error => {
          this.errors = error.response.data.errors;
          this.toggleLoader();
        });
    }
  }
};
</script>
