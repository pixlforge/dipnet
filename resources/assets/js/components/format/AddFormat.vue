<template>
  <div class="modal__slider">
    <form
      class="modal__container"
      @submit.prevent="addFormat">
      <h2 class="modal__title">Ajouter un <strong>format</strong></h2>

      <!-- Name -->
      <ModalInput
        id="name"
        ref="focus"
        v-model="format.name"
        type="text"
        required>
        <template slot="label">Nom</template>
        <template
          v-if="errors.name"
          slot="errors">
          {{ errors.name[0] }}
        </template>
      </ModalInput>

      <!-- Height -->
      <ModalInput
        id="height"
        v-model.number="format.height"
        type="number"
        required>
        <template slot="label">Hauteur <small>(mm)</small></template>
        <template
          v-if="errors.height"
          slot="errors">
          {{ errors.height[0] }}
        </template>
      </ModalInput>

      <!-- Width -->
      <ModalInput
        id="width"
        v-model.number="format.width"
        type="number"
        required>
        <template slot="label">Largeur <small>(mm)</small></template>
        <template
          v-if="errors.width"
          slot="errors">
          {{ errors.width[0] }}
        </template>
      </ModalInput>

      <!-- Surface -->
      <ModalInput
        id="surface"
        v-model="widthTimesHeight"
        type="text"
        disabled>
        <template slot="label">Largeur <small>(mm<sup>2</sup>)</small></template>
        <template
          v-if="errors.surface"
          slot="errors">
          {{ errors.surface[0] }}
        </template>
      </ModalInput>

      <!-- Controls -->
      <div class="modal__buttons">
        <button
          type="submit"
          role="button"
          class="btn btn--red">
          <i class="fal fa-check"/>
          Ajouter
        </button>
        <button
          role="button"
          class="btn btn--grey"
          @click.prevent="$emit('add-format:close')">
          <i class="fal fa-times"/>
          Annuler
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import ModalInput from "../forms/ModalInput";

import { mapActions } from "vuex";

export default {
  components: {
    ModalInput
  },
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
  mounted() {
    this.$refs.focus.$el.children[2].focus();
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    async addFormat() {
      this.toggleLoader();
      try {
        let res = await window.axios.post(
          window.route("admin.formats.store"),
          this.format
        );
        this.format = res.data;
        this.$emit("format:created", this.format);
        this.$emit("add-format:close");
        this.toggleLoader();
      } catch (err) {
        this.errors = err.response.data.errors;
        this.toggleLoader();
      }
    }
  }
};
</script>
