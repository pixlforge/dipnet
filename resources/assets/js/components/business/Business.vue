<template>
  <div>
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <div class="card__details card__details--business">
      <span>
        <strong>{{ business.name | capitalize }}</strong>
      </span>
    </div>

    <div class="card__details card__details--business">
      <span>{{ business.reference }}</span>
    </div>

    <div class="card__details card__details--business">
      <span>{{ business.description | capitalize }}</span>
    </div>

    <div class="card__details card__details--business">
      <span v-if="business.company">{{ business.company.name | capitalize }}</span>
    </div>

    <div class="card__details card__details--business">
      <span v-if="business.contact">{{ business.contact.name | capitalize }}</span>
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
    business: {
      type: Object,
      required: true
    },
    companies: {
      type: Array,
      required: true
    },
    contacts: {
      type: Array,
      required: true
    },
    user: {
      type: Object,
      required: true
    },
    users: {
      type: Array,
      required: true
    }
  },
  methods: {
    edit() {
      this.$emit("edit-business:open", this.business);
    },
    destroy() {
      window.axios.delete(
        window.route("businesses.destroy", [this.business.id])
      );
      this.$emit("business:deleted", this.business.id);
    }
  }
};
</script>
