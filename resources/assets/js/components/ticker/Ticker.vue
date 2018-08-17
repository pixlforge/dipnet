<template>
  <div>
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <div class="card__details card__details--ticker">
      <span>
        <strong>{{ ticker.body | capitalize }}</strong>
      </span>
    </div>

    <div class="card__details card__details--ticker">
      <span>{{ ticker.active ? 'Actif' : 'Inactif' }}</span>
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

