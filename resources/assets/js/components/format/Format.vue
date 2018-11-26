<template>
  <a
    :href="url"
    class="card__container">
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <!-- Name -->
    <div class="card__details card__details--format">
      <h5 class="model__label">Nom</h5>
      <span>
        <strong>{{ format.name | capitalize }}</strong>
      </span>
    </div>

    <!-- Height -->
    <div class="card__details card__details--format">
      <h5 class="model__label">Hauteur</h5>
      <span>{{ format.height }} mm</span>
    </div>

    <!-- Width -->
    <div class="card__details card__details--format">
      <h5 class="model__label">Largeur</h5>
      <span>{{ format.width }} mm</span>
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
        title="Modifier"
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
    format: {
      type: Object,
      required: true
    }
  },
  computed: {
    widthTimesHeight() {
      return this.format.height * this.format.width;
    },
    url() {
      return window.route("admin.formats.show", [this.format.id]);
    }
  },
  methods: {
    edit() {
      this.$emit("edit-format:open", this.format);
    },
    destroy() {
      if (window.confirm(`Êtes-vous certain de vouloir supprimer le format ${this.format.name}?`)) {
        window.axios.delete(
          window.route("admin.formats.destroy", [this.format.id])
        );
        this.$emit("format:deleted", this.format.id);
      }
    }
  }
};
</script>
