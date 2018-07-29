<template>
  <div class="modal__slider">
    <form
      class="modal__container"
      @submit.prevent="updateArticle">
      <h2 class="modal__title">Modifier l'article <strong>{{ article.reference }}</strong></h2>

      <!-- Description -->
      <ModalInput
        id="description"
        ref="focus"
        v-model="currentArticle.description"
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
        v-model="currentArticle.type"
        required>
        <template slot="label">Type</template>
        <template
          v-if="errors.type"
          slot="errors">
          {{ errors.type[0] }}
        </template>
      </ModalSelect>

      <!-- Greyscale -->
      <transition
        name="fade"
        mode="out-in">
        <ModalCheckbox
          v-if="currentArticle.type === 'impression'"
          id="active"
          v-model="currentArticle.greyscale">
          <template slot="label">Niveaux de gris</template>
          <template
            v-if="errors.greyscale"
            slot="errors">
            {{ errors.greyscale[0] }}
          </template>
        </ModalCheckbox>
      </transition>

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
          @click.prevent="$emit('edit-article:close')">
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
import ModalCheckbox from "../forms/ModalCheckbox";

import { mapActions } from "vuex";

export default {
  components: {
    ModalInput,
    ModalSelect,
    ModalCheckbox
  },
  props: {
    article: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      currentArticle: {
        id: this.article.id,
        description: this.article.description,
        type: this.article.type,
        greyscale: this.article.greyscale
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
    async updateArticle() {
      this.toggleLoader();
      try {
        let res = await window.axios.patch(
          window.route("admin.articles.update", [this.article.id]),
          this.currentArticle
        );
        this.$emit("article:updated", res.data);
        this.$emit("edit-article:close");
        this.toggleLoader();
      } catch (err) {
        this.errors = err.response.data;
        this.toggleLoader();
      }
    }
  }
};
</script>
