<template>
  <div class="modal__slider">
    <form
      class="modal__container"
      @submit.prevent="updateTicker">
      <h2 class="modal__title">Modifier le <strong>ticker</strong></h2>

      <!-- Body -->
      <ModalInput
        id="ticker"
        ref="focus"
        v-model="currentTicker.body"
        type="text"
        required>
        <template slot="label">Contenu</template>
        <template
          v-if="errors.body"
          slot="errors">
          {{ errors.body[0] }}
        </template>
      </ModalInput>

      <!-- Active -->
      <ModalCheckbox
        id="active"
        v-model="currentTicker.active">
        <template slot="label">Actif</template>
        <template
          v-if="errors.active"
          slot="errors">
          {{ errors.active[0] }}
        </template>
      </ModalCheckbox>

      <!-- Controls -->
      <div class="modal__buttons">
        <button
          type="submit"
          role="button"
          class="btn btn--red">
          <i class="fal fa-check"/>
          Mettre à jour
        </button>
        <button
          role="button"
          class="btn btn--grey"
          @click.prevent="$emit('edit-ticker:close')">
          <i class="fal fa-times"/>
          Annuler
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import ModalInput from "../forms/ModalInput";
import ModalCheckbox from "../forms/ModalCheckbox";

import { mapActions } from "vuex";

export default {
  components: {
    ModalInput,
    ModalCheckbox
  },
  props: {
    ticker: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      currentTicker: {
        id: this.ticker.id,
        body: this.ticker.body,
        active: this.ticker.active
      },
      errors: {}
    };
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    async updateTicker() {
      this.toggleLoader();
      try {
        let res = await window.axios.patch(
          window.route("admin.tickers.update", [this.ticker.id]),
          this.currentTicker
        );
        this.$emit("ticker:updated", res.data);
        this.$emit("edit-ticker:close");
        this.toggleLoader();
      } catch (err) {
        this.errors = err.response.data;
        this.toggleLoader();
      }
    }
  }
};
</script>
