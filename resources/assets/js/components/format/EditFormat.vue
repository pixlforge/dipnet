<template>
  <div class="modal__slider">
    <form
      class="modal__container"
      @submit.prevent="updateFormat">
      <h2 class="modal__title">Modifier le format <strong>{{ format.name }}</strong></h2>

      <!-- Name -->
      <ModalInput
        id="name"
        ref="focus"
        v-model="currentFormat.name"
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
        v-model.number="currentFormat.height"
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
        v-model.number="currentFormat.width"
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

        <!-- Submit -->
        <Button
          type="submit"
          primary
          red
          panel>
          <i class="fal fa-check"/>
          Mettre à jour
        </Button>

        <!-- Cancel -->
        <Button
          primary
          grey
          panel
          @click.prevent="$emit('edit-format:close')">
          <i class="fal fa-times"/>
          Annuler
        </Button>
      </div>
    </form>
  </div>
</template>

<script>
import Button from "../buttons/Button";
import ModalInput from "../forms/ModalInput";

import { mapActions } from "vuex";

export default {
  components: {
    Button,
    ModalInput
  },
  props: {
    format: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      currentFormat: {
        id: this.format.id,
        name: this.format.name,
        height: this.format.height,
        width: this.format.width
      },
      errors: {}
    };
  },
  computed: {
    widthTimesHeight() {
      if (this.currentFormat.width && this.currentFormat.height) {
        return (
          this.currentFormat.width * this.currentFormat.height
        ).toLocaleString("fr");
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
    async updateFormat() {
      this.toggleLoader();
      try {
        let res = await window.axios.patch(
          window.route("admin.formats.update", [this.format.id]),
          this.currentFormat
        );
        this.$emit("format:updated", res.data);
        this.$emit("edit-format:close");
        this.toggleLoader();
      } catch (err) {
        this.errors = err.response.data;
        this.toggleLoader();
      }
    }
  }
};
</script>
