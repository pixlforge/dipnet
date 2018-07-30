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
            class="btn btn--red"
            @click="createCompany">
            <i class="fal fa-check"/>
            Terminer l'enregistrement
          </button>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import { mapActions } from "vuex";
import { appName, logo, registration } from "../../mixins";

export default {
  mixins: [appName, logo, registration],
  data() {
    return {
      company: {
        name: ""
      },
      errors: {}
    };
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    async createCompany() {
      this.toggleLoader();
      try {
        await window.axios.post(
          window.route("register.company.store"),
          this.company
        );
        this.$emit("company:created");
        this.company = {};
      } catch (err) {
        this.errors = err.response.data.errors;
        this.toggleLoader();
      }
    }
  }
};
</script>

<style scoped>
a {
  cursor: pointer;
}

.company-logo-container {
  position: fixed;
}
</style>
