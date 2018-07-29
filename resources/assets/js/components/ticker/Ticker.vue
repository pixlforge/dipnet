<template>
  <div>
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <div class="card__title">
      {{ ticker.body | capitalize }}
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">{{ ticker.active ? 'Actif' : 'Inactif' }}</span>
      </div>
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Créé</span>
        {{ getDate(ticker.created_at) }}
      </div>
      <div>
        <span class="card__label">Modifié</span>
        {{ getDate(ticker.updated_at) }}
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
import { filters, dates } from "../../mixins";

export default {
  mixins: [filters, dates],
  props: {
    ticker: {
      type: Object,
      required: true
    }
  },
  methods: {
    edit() {
      this.$emit("edit-ticker:open", this.ticker);
    },
    destroy() {
      window.axios.delete(
        window.route("admin.tickers.destroy", [this.ticker.id])
      );
      this.$emit("ticker:deleted", this.ticker.id);
    }
  }
};
</script>

