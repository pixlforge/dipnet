<template>
  <div class="register__container">
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
      <form
        class="register__form register__form--details"
        @submit.prevent="createCompany">
        <h1 class="register__title">Votre <strong>société</strong></h1>

        <!-- Name -->
        <ModalInput
          id="name"
          ref="focus"
          v-model="company.name"
          type="text"
          required>
          <template slot="label">Nom de la société</template>
          <template
            v-if="errors.name"
            slot="errors">
            {{ errors.name[0] }}
          </template>
        </ModalInput>

        <div class="register__buttons">
          <Button
            type="submit"
            primary
            red
            long>
            <i class="fal fa-check"/>
            Terminer l'enregistrement
          </Button>
        </div>
      </form>
    </section>
  </div>
</template>

<script>
import Button from "../buttons/Button";
import ModalInput from "../forms/ModalInput";

import { mapActions } from "vuex";
import { appName, logo, registration } from "../../mixins";

export default {
  components: {
    Button,
    ModalInput
  },
  mixins: [appName, logo, registration],
  data() {
    return {
      company: {
        name: ""
      },
      errors: {}
    };
  },
  mounted() {
    this.$refs.focus.$el.children[2].focus();
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
