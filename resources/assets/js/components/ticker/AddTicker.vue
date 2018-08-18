<template>
  <div class="modal__slider">
    <form
      class="modal__container"
      @submit.prevent="addTicker">
      <h2 class="modal__title">Ajouter un <strong>ticker</strong></h2>

      <!-- Body -->
      <ModalInput
        id="ticker"
        ref="focus"
        v-model="ticker.body"
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
        v-model="ticker.active">
        <template slot="label">Actif</template>
        <template
          v-if="errors.active"
          slot="errors">
          {{ errors.active[0] }}
        </template>
      </ModalCheckbox>

      <!-- Controls -->
      <div class="modal__buttons">

        <!-- Submit -->
        <Button
          type="submit"
          primary
          red
          long>
          <i class="fal fa-check"/>
          Ajouter
        </Button>

        <!-- Cancel -->
        <Button
          primary
          grey
          long
          @click.prevent="$emit('add-ticker:close')">
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
import ModalCheckbox from "../forms/ModalCheckbox";

import { mapActions } from "vuex";

export default {
  components: {
    Button,
    ModalInput,
    ModalCheckbox
  },
  data() {
    return {
      ticker: {
        body: "",
        active: false
      },
      errors: {}
    };
  },
  mounted() {
    this.$refs.focus.$el.children[2].focus();
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    async addTicker() {
      this.toggleLoader();
      try {
        let res = await window.axios.post(
          window.route("admin.tickers.store"),
          this.ticker
        );
        this.$emit("ticker:created", res.data);
        this.$emit("add-ticker:close");
        this.toggleLoader();
      } catch (err) {
        this.errors = err.response.data.errors;
        this.toggleLoader();
      }
    }
  }
};
</script>
