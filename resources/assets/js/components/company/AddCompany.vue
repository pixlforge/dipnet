<template>
  <div class="modal__slider">
    <form
      class="modal__container"
      @submit.prevent="addCompany">
      <h2 class="modal__title">Ajouter une <strong>société</strong></h2>

      <!-- Name -->
      <ModalInput
        id="name"
        ref="focus"
        v-model="company.name"
        type="text"
        required>
        <template slot="label">Nom</template>
        <template
          v-if="errors.name"
          slot="errors">
          {{ errors.name[0] }}
        </template>
      </ModalInput>

      <!-- Status -->
      <ModalSelect
        id="status"
        :options="optionsForStatus"
        v-model="company.status"
        required>
        <template slot="label">Statut</template>
        <template
          v-if="errors.status"
          slot="errors">
          {{ errors.status[0] }}
        </template>
      </ModalSelect>

      <!-- Description -->
      <ModalInput
        id="description"
        ref="focus"
        v-model="company.description"
        type="text"
        required>
        <template slot="label">Description</template>
        <template
          v-if="errors.description"
          slot="errors">
          {{ errors.description[0] }}
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
          @click.prevent="$emit('add-company:close')">
          <i class="fal fa-times"/>
          Annuler
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import ModalInput from "../forms/ModalInput";
import ModalSelect from "../forms/ModalSelect";

import { mapActions } from "vuex";

export default {
  components: {
    ModalInput,
    ModalSelect
  },
  data() {
    return {
      company: {
        name: "",
        status: "",
        description: ""
      },
      errors: {},
      optionsForStatus: [
        { label: "Temporaire", value: "temporaire" },
        { label: "Permanent", value: "permanent" }
      ]
    };
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    async addCompany() {
      this.toggleLoader();
      try {
        let res = await window.axios.post(
          window.route("admin.companies.store"),
          this.company
        );
        this.company = res.data;
        this.$emit("company:created", this.company);
        this.$emit("add-company:close");
        this.toggleLoader();
      } catch (err) {
        this.errors = err.response.data.errors;
        this.toggleLoader();
      }
    }
  }
};
</script>
