<template>
  <a
    :href="url"
    class="card__container">
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <!-- Description -->
    <div class="card__details card__details--article">
      <h5 class="model__label">Description</h5>
      <span>
        <strong>{{ article.description | capitalize }}</strong>
      </span>
    </div>

    <!-- Reference -->
    <div class="card__details card__details--article">
      <h5 class="model__label">Référence</h5>
      <span>{{ article.reference }}</span>
    </div>

    <!-- Type -->
    <div class="card__details card__details--article">
      <h5 class="model__label">Type</h5>
      <span>{{ article.type | capitalize }}</span>
    </div>

    <!-- Controls -->
    <div class="card__controls">
      
      <!-- Delete -->
      <Button
        title="Supprimer"
        @click.prevent="destroy">
        <i class="fal fa-times"/>
      </Button>

      <!-- Edit -->
      <Button
        title="Supprimer"
        @click.prevent="edit">
        <i class="fal fa-pencil"/>
      </Button>
    </div>
  </a>
</template>

<script>
import Button from "../buttons/Button";

import { filters } from "../../mixins";

export default {
  components: {
    Button
  },
  mixins: [filters],
  props: {
    article: {
      type: Object,
      required: true
    }
  },
  computed: {
    url() {
      return window.route("admin.articles.show", [this.article.id]);
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
