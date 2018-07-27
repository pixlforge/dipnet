<template>
  <div>
    <button
      class="btn btn--red-large"
      @click="toggleModal">
      <i class="fal fa-plus-circle"/>
      Nouvelle société
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
        @keyup.enter="addCompany">

        <div class="modal__container">
          <h2 class="modal__title">Nouvelle société</h2>

          <div class="modal__group">
            <label
              for="name"
              class="modal__label">
              Nom
            </label>
            <span class="modal__required">*</span>
            <input
              id="name"
              v-model.trim="company.name"
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

          <div class="modal__group">
            <label
              for="status"
              class="modal__label">
              Statut
            </label>
            <span class="modal__required">*</span>
            <select
              id="status"
              v-model.trim="company.status"
              name="status"
              class="modal__select">
              <option disabled>Sélectionnez un statut</option>
              <option value="temporaire">Temporaire</option>
              <option value="permanent">Permanent</option>
            </select>
            <div
              v-if="errors.status"
              class="modal__alert">
              {{ errors.status[0] }}
            </div>
          </div>

          <div class="modal__group">
            <label
              for="description"
              class="modal__label">
              Description
            </label>
            <input
              id="description"
              v-model.trim="company.description"
              type="text"
              name="description"
              class="modal__input">
            <div
              v-if="errors.description"
              class="modal__alert">
              {{ errors.description[0] }}
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
              @click.prevent="addCompany">
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
import { mapActions } from "vuex";

export default {
  mixins: [mixins],
  data() {
    return {
      company: {
        name: "",
        status: "",
        description: ""
      },
      errors: {}
    };
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    addCompany() {
      this.$store.dispatch("toggleLoader");
      window.axios
        .post(window.route("admin.companies.store"), this.company)
        .then(res => {
          this.company = res.data;
          this.$emit("companyWasCreated", this.company);
          this.$store.dispatch("toggleLoader");
          this.toggleModal();
          window.flash({
            message: "La création de la société a réussi.",
            level: "success"
          });
          this.company = {};
        })
        .catch(err => {
          this.$store.dispatch("toggleLoader");
          this.errors = err.response.data.errors;
        });
    }
  }
};
</script>
