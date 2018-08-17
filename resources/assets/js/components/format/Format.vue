<template>
  <div>
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
    format: {
      type: Object,
      required: true
    }
  },
  computed: {
    widthTimesHeight() {
      return this.format.height * this.format.width;
    }
  },
  methods: {
    edit() {
      this.$emit("edit-format:open", this.format);
    },
    destroy() {
      window.axios.delete(
        window.route("admin.formats.destroy", [this.format.id])
      );
      this.$emit("format:deleted", this.format.id);
    }
  }
};
</script>
