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
        @keyup.enter="updateArticle">

        <div class="modal__container">
          <h2 class="modal__title">
            Modifier l'article
            <strong>{{ article.reference }}</strong>
          </h2>

          <!-- Description -->
          <div class="modal__group">
            <label
              for="description"
              class="modal__label">
              Description
            </label>
            <input
              id="description"
              v-model.trim="article.description"
              type="text"
              name="description"
              class="modal__input"
              required>
            <div
              v-if="errors.description"
              class="modal__alert">
              {{ errors.description[0] }}
            </div>
          </div>

          <!-- Type -->
          <div class="modal__group">
            <label
              for="type"
              class="modal__label">
              Type
            </label>
            <select
              id="type"
              v-model.trim="article.type"
              name="type"
              class="modal__select">
              <option disabled>Sélectionnez un type</option>
              <option value="option">Option</option>
              <option value="impression">Impression</option>
            </select>
            <div
              v-if="errors.type"
              class="modal__alert">
              {{ errors.type[0] }}
            </div>
          </div>

          <!-- Article Type -->
          <transition
            name="fade"
            mode="out-in">
            <div
              v-if="article.type === 'impression'"
              class="modal__group">
              <label
                for="greyscale"
                class="modal__label">
                <input
                  id="greyscale"
                  v-model="article.greyscale"
                  type="checkbox"
                  name="greyscale">
                Niveaux de gris
              </label>
            </div>
          </transition>

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
              @click.prevent="updateArticle">
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
    article: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      errors: {}
    };
  },
  methods: {
    updateArticle() {
      this.$store.dispatch("toggleLoader");
      window.axios
        .patch(
          window.route("admin.articles.update", [this.article.id]),
          this.article
        )
        .then(() => {
          eventBus.$emit("articleWasUpdated", this.article);
          this.$store.dispatch("toggleLoader");
          this.toggleModal();
        })
        .catch(() => {
          this.$store.dispatch("toggleLoader");
        });
    }
  }
};
</script>
