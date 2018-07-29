<template>
  <div>
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <div class="card__title">
      {{ article.reference }}
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Description</span>
        {{ article.description | capitalize }}
      </div>
      <div>
        <span class="card__label">Type</span>
        {{ article.type | capitalize }}
      </div>
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Créé</span>
        {{ getDate(article.created_at) }}
      </div>
      <div>
        <span class="card__label">Modifié</span>
        {{ getDate(article.updated_at) }}
      </div>
    </div>

    <div class="card__controls">
      <button
        role="button"
        title="Supprimer"
        @click.prevent="destroy">
        <i class="fal fa-times"/>
      </button>
      <button
        role="button"
        title="Modifier"
        @click.prevent="edit">
        <i class="fal fa-pencil"/>
      </button>
    </div>
  </div>
</template>

<script>
import EditArticle from "./EditArticle.vue";

import { filters, dates } from "../../mixins";

export default {
  components: {
    EditArticle
  },
  mixins: [filters, dates],
  props: {
    article: {
      type: Object,
      required: true
    }
  },
  methods: {
    edit() {
      this.$emit("edit-article:open", this.article);
    },
    destroy() {
      window.axios.delete(
        window.route("admin.articles.destroy", [this.article.id])
      );
      this.$emit("article:deleted", this.article.id);
    }
  }
};
</script>
