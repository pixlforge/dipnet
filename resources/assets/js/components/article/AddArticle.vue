<template>
  <div class="modal__slider">
    <form
      class="modal__container"
      @submit.prevent="addArticle">
      <h2 class="modal__title">Ajouter un <strong>article</strong></h2>

      <!-- Description -->
      <ModalInput
        id="description"
        ref="focus"
        v-model="article.description"
        type="text"
        required>
        <template slot="label">Description</template>
        <template
          v-if="errors.description"
          slot="errors">
          {{ errors.description[0] }}
        </template>
      </ModalInput>

      <!-- Type -->
      <ModalSelect
        id="type"
        :options="optionsForType"
        v-model="article.type"
        required>
        <template slot="label">Type</template>
        <template
          v-if="errors.type"
          slot="errors">
          {{ errors.type[0] }}
        </template>
      </ModalSelect>

      <!-- Greyscale -->
      <ModalCheckbox
        v-if="article.type === 'impression'"
        id="active"
        v-model="article.greyscale">
        <template slot="label">Niveaux de gris</template>
        <template
          v-if="errors.greyscale"
          slot="errors">
          {{ errors.greyscale[0] }}
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
          @click.prevent="$emit('add-article:close')">
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
import ModalSelect from "../forms/ModalSelect";
import ModalCheckbox from "../forms/ModalCheckbox";

import { mapActions } from "vuex";

export default {
  components: {
    Button,
    ModalInput,
    ModalSelect,
    ModalCheckbox
  },
  data() {
    return {
      article: {
        description: "",
        type: "",
        greyscale: false
      },
      errors: {},
      optionsForType: [
        { label: "Option", value: "option" },
        { label: "Impression", value: "impression" }
      ]
    };
  },
  mounted() {
    this.$refs.focus.$el.children[2].focus();
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    async addArticle() {
      this.toggleLoader();
      try {
        let res = await window.axios.post(
          window.route("admin.articles.store"),
          this.article
        );
        this.article = res.data;
        this.$emit("article:created", this.article);
        this.$emit("add-article:close");
        this.toggleLoader();
      } catch (err) {
        this.errors = err.response.data.errors;
        this.toggleLoader();
      }
    }
  }
};
</script>
