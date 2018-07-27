<template>
  <div>
    <button
      class="btn btn--red-large"
      @click="toggleModal">
      <i class="fal fa-plus-circle"/>
      Nouvel article
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
        @keyup.enter="addArticle">

        <div class="modal__container">
          <h2 class="modal__title">Nouvel article</h2>

          <!--Description-->
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

          <!--Type-->
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

          <!--Greyscale-->
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

          <!--Buttons-->
          <div class="modal__buttons">
            <button
              class="btn btn--grey"
              @click.stop="toggleModal">
              <i class="fal fa-times"/>
              Annuler
            </button>
            <button
              class="btn btn--red"
              @click.prevent="addArticle">
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
      article: {
        description: "",
        type: "",
        greyscale: false
      },
      errors: {}
    };
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    addArticle() {
      this.$store.dispatch("toggleLoader");
      window.axios
        .post(window.route("admin.articles.store"), this.article)
        .then(res => {
          this.article = res.data;
          this.$emit("articleWasCreated", this.article);
          this.$store.dispatch("toggleLoader");
          this.toggleModal();
          this.article = {};
        })
        .catch(error => {
          this.$store.dispatch("toggleLoader");
          this.errors = error.response.data.errors;
        });
    }
  }
};
</script>
