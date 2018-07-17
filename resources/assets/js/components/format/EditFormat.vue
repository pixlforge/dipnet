<template>
  <div>
    <div
      role="button"
      @click="toggleModal">
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
        @keyup.enter="updateFormat">

        <div class="modal__container">
          <h2 class="modal__title">Modifier {{ format.name }}</h2>

          <div class="modal__group">
            <label
              for="name"
              class="modal__label">
              Nom
            </label>
            <span class="modal__required">*</span>
            <input
              id="name"
              v-model.trim="format.name"
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
              for="height"
              class="modal__label">
              Hauteur (mm)
            </label>
            <span class="modal__required">*</span>
            <input
              id="height"
              v-model.number="format.height"
              type="number"
              name="height"
              class="modal__input">
            <div
              v-if="errors.height"
              class="modal__alert">
              {{ errors.height[0] }}
            </div>
          </div>

          <div class="modal__group">
            <label
              for="width"
              class="modal__label">
              Largeur (mm)
            </label>
            <span class="modal__required">*</span>
            <input
              id="width"
              v-model.number="format.width"
              type="number"
              name="width"
              class="modal__input">
            <div
              v-if="errors.width"
              class="modal__alert">
              {{ errors.width[0] }}
            </div>
          </div>

          <div class="modal__group">
            <label
              for="surface"
              class="modal__label">
              Surface (mm<sup>2</sup>)
            </label>
            <input
              id="surface"
              :value="widthTimesHeight"
              type="text"
              name="surface"
              class="modal__input modal__input--disabled"
              disabled>
            <div
              v-if="errors.surface"
              class="modal__alert">
              {{ errors.surface[0] }}
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
              @click.prevent="updateFormat">
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
    format: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      errors: {}
    };
  },
  computed: {
    widthTimesHeight() {
      if (this.format.width && this.format.height) {
        return (this.format.width * this.format.height).toLocaleString("fr");
      } else {
        return 0;
      }
    }
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    updateFormat() {
      this.$store.dispatch("toggleLoader");
      window.axios
        .patch(
          window.route("admin.formats.update", [this.format.id]),
          this.format
        )
        .then(() => {
          eventBus.$emit("formatWasUpdated", this.format);
        })
        .then(() => {
          this.$store.dispatch("toggleLoader");
          this.toggleModal();
        })
        .catch(error => {
          this.$store.dispatch("toggleLoader");
          this.errors = error.response.data;
        });
    }
  }
};
</script>
