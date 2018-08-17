<template>
  <div>
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <div class="card__details card__details--user">
      <span>
        <strong>{{ user.username | capitalize }}</strong>
      </span>
    </div>

    <div class="card__details card__details--user">
      <span>{{ user.email }}</span>
    </div>

    <div class="card__details card__details--user">
      <span>{{ user.role | capitalize }}</span>
    </div>

    <div class="card__details card__details--user">
      <span v-if="user.company">{{ user.company.name | capitalize }}</span>
    </div>

    <div class="card__details card__details--user">
      <div class="card__details-group">
        <span>Compte</span>
        <span v-if="user.email_confirmed">
          <i class="fal fa-check-circle text--success"/>
        </span>
        <span v-else>
          <i class="fal fa-times-circle text--warning"/>
        </span>
      </div>
      <div
        v-if="userIsNotAdmin"
        class="card__details-group">
        <span>Contact</span>
        <span v-if="user.contact_confirmed">
          <i class="fal fa-check-circle text--success"/>
        </span>
        <span v-else>
          <i class="fal fa-times-circle text--warning"/>
        </span>
      </div>
      <div
        v-if="userIsNotAdmin"
        class="card__details-group">
        <span>Société</span>
        <span v-if="user.company_confirmed">
          <i class="fal fa-check-circle text--success"/>
        </span>
        <span v-else>
          <i class="fal fa-times-circle text--warning"/>
        </span>
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
    user: {
      type: Object,
      required: true
    }
  },
  computed: {
    userIsNotAdmin() {
      return this.user.role === "" || this.user.role === "utilisateur";
    }
  },
  methods: {
    edit() {
      this.$emit("edit-user:open", this.user);
    },
    destroy() {
      window.axios.delete(window.route("admin.users.destroy", [this.user.id]));
      this.$emit("user:deleted", this.user.id);
    }
  }
};
</script>
