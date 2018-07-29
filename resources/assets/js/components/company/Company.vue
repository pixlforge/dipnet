<template>
  <div>
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <div class="card__title">
      {{ company.name | capitalize }}
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Description</span>
        {{ company.description | capitalize }}
      </div>
      <div>
        <span class="card__label">Statut</span>
        {{ company.status | capitalize }}
      </div>
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Créé</span>
        {{ getDate(company.created_at) }}
      </div>
      <div>
        <span class="card__label">Modifié</span>
        {{ getDate(company.updated_at) }}
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
