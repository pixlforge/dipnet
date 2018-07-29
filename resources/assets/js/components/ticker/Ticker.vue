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
      <div
        role="button"
        title="Supprimer"
        @click="destroy">
        <i class="fal fa-times"/>
      </div>
      <div title="Modifier">
        <EditTicker :ticker="ticker"/>
      </div>
    </div>
  </div>
</template>

<script>
import EditTicker from "./EditTicker";

import { filters, dates } from "../../mixins";

export default {
  components: {
    EditTicker
  },
  mixins: [filters, dates],
  props: {
    ticker: {
      type: Object,
      required: true
    }
  },
  methods: {
    destroy() {
      window.axios.delete(
        window.route("admin.tickers.destroy", [this.ticker.id])
      );
      this.$emit("ticker:deleted", this.ticker.id);
    }
  }
};
</script>

