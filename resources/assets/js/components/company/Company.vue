<template>
  <a
    :href="url"
    class="card__container">
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <!-- Name -->
    <div class="card__details card__details--company">
      <h5 class="model__label">Nom</h5>
      <span>
        <strong>{{ company.name | capitalize }}</strong>
      </span>
    </div>

    <!-- Description -->
    <div class="card__details card__details--company">
      <template v-if="company.description">
        <h5 class="model__label">Description</h5>
        <span>{{ company.description | capitalize }}</span>
      </template>
    </div>

    <!-- Controls -->
    <div class="card__controls">

      <!-- Delete -->
      <Button
        title="Supprimer"
        @click.prevent="destroy">
        <i class="fal fa-times"/>
      </Button>

      <!-- Edit -->
      <Button
        title="Modifier"
        @click.prevent="edit">
        <i class="fal fa-pencil"/>
      </Button>
    </div>
  </a>
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
  computed: {
    url() {
      return window.route("companies.show", [this.company.slug]);
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
