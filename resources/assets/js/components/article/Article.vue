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
        <edit-article :article="article"/>
      </div>
    </div>
  </div>
</template>

<script>
import EditArticle from "./EditArticle.vue";
import mixins from "../../mixins";

export default {
  components: {
    EditArticle
  },
  mixins: [mixins],
  props: {
    article: {
      type: Object,
      required: true
    }
  },
  methods: {
    destroy() {
      window.axios.delete(window.route("articles.destroy", [this.article.id]));
      this.$emit("articleWasDeleted", this.article.id);
    }
  }
};
</script>
