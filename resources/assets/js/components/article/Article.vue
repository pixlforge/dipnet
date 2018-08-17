<template>
  <div>
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <div class="card__details card__details--article">
      <span>
        <strong>{{ article.description | capitalize }}</strong>
      </span>
    </div>

    <div class="card__details card__details--article">
      <span>{{ article.reference }}</span>
    </div>

    <div class="card__details card__details--article">
      <span>{{ article.type | capitalize }}</span>
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
import { filters } from "../../mixins";

export default {
  mixins: [filters],
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
