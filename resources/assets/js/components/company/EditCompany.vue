<template>
  <div>
    <div @click="toggleModal">
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
        @keyup.enter="updateCompany">
        <div class="modal__container">
          <h2 class="modal__title">Modifier {{ company.name }}</h2>

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
              role="button"
              class="btn btn--grey"
              @click.stop="toggleModal">
              <i class="fal fa-times"/>
              Annuler
            </button>
            <button
              role="button"
              class="btn btn--red"
              @click.prevent="updateCompany">
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
import { modal } from "../../mixins";
import { eventBus } from "../../app";
import { mapActions } from "vuex";

export default {
  mixins: [modal],
  props: {
    company: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      errors: {}
    };
  },
  created() {
    eventBus.$on("open:edit-company", () => {
      this.toggleModal();
    });
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    updateCompany() {
      this.toggleLoader();
      window.axios
        .put(window.route("companies.update", [this.company.id]), this.company)
        .then(() => {
          eventBus.$emit("company:updated", this.company);
          this.toggleLoader();
          this.toggleModal();
        })
        .catch(() => {
          this.toggleLoader();
        });
    }
  }
};
</script>
