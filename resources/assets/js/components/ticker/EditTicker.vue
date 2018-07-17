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
        @keyup.enter="update">

        <div class="modal__container">
          <h2 class="modal__title">Modifier le ticker</h2>

          <div class="modal__group">
            <label
              for="body"
              class="modal__label">
              Contenu
            </label>
            <span class="modal__required">*</span>
            <input
              id="body"
              v-model.trim="ticker.body"
              type="text"
              name="body"
              class="modal__input"
              required
              autofocus>
            <div
              v-if="errors.body"
              class="modal__alert">
              {{ errors.body[0] }}
            </div>
          </div>

          <div class="modal__group">
            <label
              for="active"
              class="modal__label">
              <input
                id="active"
                v-model="ticker.active"
                type="checkbox"
                name="active">
              Actif
            </label>
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
              @click.prevent="update">
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
import { mapActions } from "vuex";

export default {
  mixins: [mixins],
  props: {
    ticker: {
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
    ...mapActions(["toggleLoader"]),
    update() {
      this.$store.dispatch("toggleLoader");
      window.axios
        .patch(
          window.route("admin.tickers.update", [this.ticker.id]),
          this.ticker
        )
        .then(() => {
          eventBus.$emit("tickerWasUpdated", this.ticker);
        })
        .then(() => {
          this.$store.dispatch("toggleLoader");
          this.toggleModal();
        })
        .catch(err => {
          this.$store.dispatch("toggleLoader");
          this.errors = err.response.data;
        });
    }
  }
};
</script>
