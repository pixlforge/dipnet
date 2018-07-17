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
        title="Supprimer"
        role="button"
        @click="destroy">
        <i class="fal fa-times"/>
      </div>
      <div title="Modifier">
        <edit-ticker :ticker="ticker"/>
      </div>
    </div>
  </div>
</template>

<script>
import EditTicker from "./EditTicker";
import mixins from "../../mixins";

export default {
  components: {
    EditTicker
  },
  mixins: [mixins],
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
      this.$emit("tickerWasDeleted", this.ticker.id);
    }
  }
};
</script>

