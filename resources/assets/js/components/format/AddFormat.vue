<template>
  <div>
    <button
      class="btn btn--red-large"
      role="button"
      @click="toggleModal">
      <i class="fal fa-plus-circle"/>
      Nouveau format
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
        @keyup.enter="addFormat">

        <div class="modal__container">
          <h2 class="modal__title">Nouveau format</h2>

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
              @click.prevent="addFormat">
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
import { modal } from "../../mixins";
import { mapActions } from "vuex";

export default {
  mixins: [modal],
  data() {
    return {
      format: {
        name: "",
        height: null,
        width: null
      },
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
    addFormat() {
      this.toggleLoader();
      window.axios
        .post(window.route("admin.formats.store"), this.format)
        .then(res => {
          this.format = res.data;
          this.$emit("format:created", this.format);
          this.toggleLoader();
          this.toggleModal();
          this.format = {};
        })
        .catch(err => {
          this.errors = err.response.data.errors;
          this.toggleLoader();
        });
    }
  }
};
</script>
