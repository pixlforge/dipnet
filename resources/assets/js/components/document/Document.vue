<template>
  <div class="card__container">
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <!-- File name -->
    <div class="card__details card__details--document">
      <h5 class="model__label">Nom du fichier</h5>
      <span>
        <strong>{{ document.media[0].file_name }}</strong>
      </span>
    </div>

    <!-- Mime type -->
    <div class="card__details card__details--document">
      <h5 class="model__label">Format</h5>
      <span>{{ document.media[0].mime_type }}</span>
    </div>

    <!-- Size -->
    <div class="card__details card__details--document">
      <h5 class="model__label">Taille</h5>
      <span>{{ getFilesize }}</span>
    </div>

    <!-- Article -->
    <div class="card__details card__details--document">
      <template v-if="document.article">
        <h5 class="model__label">Impression</h5>
        <span>{{ document.article.description }}</span>
      </template>
    </div>

    <!-- Finish -->
    <div class="card__details card__details--document">
      <h5 class="model__label">Finition</h5>
      <span>{{ document.finish | capitalize }}</span>
    </div>

    <!-- Quantity -->
    <div class="card__details card__details--document">
      <h5 class="model__label">Quantité</h5>
      <span>{{ document.quantity }}</span>
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