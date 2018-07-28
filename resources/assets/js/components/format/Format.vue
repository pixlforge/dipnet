<template>
  <div>
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <div class="card__title">
      {{ format.name | capitalize }}
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Hauteur</span>
        {{ format.height }} mm
      </div>
      <div>
        <span class="card__label">Largeur</span>
        {{ format.width }} mm
      </div>
      <div>
        <span class="card__label">Surface</span>
        {{ widthTimesHeight }} mm<sup>2</sup>
      </div>
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Créé</span>
        {{ getDate(format.created_at) }}
      </div>
      <div>
        <span class="card__label">Modifié</span>
        {{ getDate(format.updated_at) }}
      </div>
    </div>

    <div class="card__controls">
      <div
        title="Supprimer"
        role="button"
        @click="destroy">
        <i class="fal fa-times"/>
      </div>
      <div title="Modifier">
        <EditFormat :format="format"/>
      </div>
    </div>
  </div>
</template>

<script>
import EditFormat from "./EditFormat.vue";

import { filters, dates } from "../../mixins";

export default {
  components: {
    EditFormat
  },
  mixins: [filters, dates],
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
    destroy() {
      window.axios.delete(
        window.route("admin.formats.destroy", [this.format.id])
      );
      this.$emit("format:deleted", this.format.id);
    }
  }
};
</script>
