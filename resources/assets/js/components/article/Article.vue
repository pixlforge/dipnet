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
      <div
        title="Supprimer"
        @click="destroy">
        <i class="fal fa-times"/>
      </div>
      <div title="Modifier">
        <EditArticle :article="article"/>
      </div>
    </div>
  </div>
</template>

<script>
import EditArticle from "./EditArticle.vue";

export default {
  components: {
    EditArticle
  },
  props: {
    article: {
      type: Object,
      required: true
    }
  },
  methods: {
    destroy() {
      window.axios.delete(
        window.route("admin.articles.destroy", [this.article.id])
      );
      this.$emit("article:deleted", this.article.id);
    }
  }
};
</script>
