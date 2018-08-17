<template>
  <div>
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <div class="card__details card__details--document">
      <span>
        <strong>{{ document.media[0].file_name }}</strong>
      </span>
    </div>

    <div class="card__details card__details--document">
      <span>{{ document.media[0].mime_type }}</span>
    </div>

    <div class="card__details card__details--document">
      <span>{{ getFilesize }}</span>
    </div>

    <div class="card__details card__details--document">
      <span v-if="document.article">{{ document.article.description }}</span>
    </div>

    <div class="card__details card__details--document">
      <span>{{ document.finish | capitalize }}</span>
    </div>

    <div class="card__details card__details--document">
      <span>Quantité: {{ document.quantity }}</span>
    </div>
  </div>
</template>

<script>
import filesize from "filesize";
import { filters } from "../../mixins";

export default {
  mixins: [filters],
  props: {
    document: {
      type: Object,
      required: true
    }
  },
  computed: {
    getFilesize() {
      return filesize(this.document.media[0].size);
    }
  }
};
</script>