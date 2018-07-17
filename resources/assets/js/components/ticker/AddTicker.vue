<template>
  <div>
    <button
      class="btn btn--red-large"
      role="button"
      @click="toggleModal">
      <i class="fal fa-plus-circle"/>
      Nouveau ticker
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
        @keyup.enter="add">

        <div class="modal__container">
          <h2 class="modal__title">Nouveau ticker</h2>

          <div class="modal__group">
            <label
              for="name"
              class="modal__label">
              Contenu
            </label>
            <span class="modal__required">*</span>
            <input
              id="ticker"
              v-model.trim="ticker.body"
              type="text"
              name="ticker"
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
              @click.prevent="add">
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
      ticker: {
        body: "",
        active: false
      },
      errors: {}
    };
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    add() {
      this.$store.dispatch("toggleLoader");
      window.axios
        .post(window.route("admin.tickers.store"), this.ticker)
        .then(res => {
          this.ticker = res.data;
          this.$emit("tickerWasCreated", this.ticker);
          this.$store.dispatch("toggleLoader");
          this.toggleModal();
          this.ticker = {
            body: "",
            active: false
          };
        })
        .catch(err => {
          this.$store.dispatch("toggleLoader");
          this.errors = err.response.data.errors;
        });
    }
  }
};
</script>
