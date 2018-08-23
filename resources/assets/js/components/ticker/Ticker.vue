<template>
  <a
    :href="url"
    class="card__container">
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <!-- Body -->
    <div class="card__details card__details--ticker">
      <h5 class="model__label">Contenu</h5>
      <span>
        <strong>{{ ticker.body | capitalize }}</strong>
      </span>
    </div>

    <!-- Active -->
    <div class="card__details card__details--ticker">
      <span
        :class="statusClass"
        class="badge">
        {{ ticker.active ? 'Actif' : 'Inactif' }}
      </span>
    </div>

    <!-- Controls -->
    <div class="card__controls">
      <Button
        title="Supprimer"
        @click.prevent="destroy">
        <i class="fal fa-times"/>
      </Button>
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
    ticker: {
      type: Object,
      required: true
    }
  },
  computed: {
    statusClass() {
      if (this.ticker.active) {
        return "badge--success";
      }
      return "badge--danger";
    },
    url() {
      return window.route("admin.tickers.show", [this.ticker.id]);
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

