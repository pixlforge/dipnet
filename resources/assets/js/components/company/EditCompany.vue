<template>
  <div class="modal__slider">
    <form
      class="modal__container"
      @submit.prevent="updateCompany">
      <h2 class="modal__title">Modifier la société <strong>{{ company.name }}</strong></h2>

      <!-- Name -->
      <ModalInput
        id="name"
        ref="focus"
        v-model="currentCompany.name"
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
        v-model="currentCompany.status"
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
        v-model="currentCompany.description"
        type="text">
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
          Mettre à jour
        </button>
        <button
          role="button"
          class="btn btn--grey"
          @click.prevent="$emit('edit-company:close')">
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
  props: {
    company: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      currentCompany: {
        id: this.company.id,
        name: this.company.name,
        status: this.company.status,
        description: this.company.description
      },
      errors: {},
      optionsForStatus: [
        { label: "Temporaire", value: "temporaire" },
        { label: "Permanent", value: "permanent" }
      ]
    };
  },
  mounted() {
    this.$refs.focus.$el.children[2].focus();
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    async updateCompany() {
      this.toggleLoader();
      try {
        let res = await window.axios.patch(
          window.route("admin.companies.update", [this.company.slug]),
          this.currentCompany
        );
        this.$emit("company:updated", res.data);
        this.$emit("edit-company:close");
        this.toggleLoader();
      } catch (err) {
        this.errors = err.response.data.errors;
        this.toggleLoader();
      }
    }
  }
};
</script>
