<template>
  <div>
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <div class="card__details card__details--company">
      <span>
        <strong>{{ company.name | capitalize }}</strong>
      </span>
    </div>

    <div class="card__details card__details--company">
      <span>{{ company.description | capitalize }}</span>
    </div>

    <div class="card__details card__details--company">
      <span>{{ company.status | capitalize }}</span>
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
    company: {
      type: Object,
      required: true
    }
  },
  methods: {
    edit() {
      this.$emit("edit-company:open", this.company);
    },
    destroy() {
      window.axios.delete(window.route("companies.destroy", [this.company.id]));
      this.$emit("company:deleted", this.company.id);
    }
  }
};
</script>
