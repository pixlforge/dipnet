<template>
  <div>
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <div class="card__title">
      {{ user.username | capitalize }}
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Role</span>
        {{ user.role | capitalize }}
      </div>
      <div>
        <span class="card__label">Email</span>
        {{ user.email }}
      </div>
      <div v-if="user.company">
        <span class="card__label">Société</span>
        {{ user.company.name | capitalize }}
      </div>
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Compte</span>
        <span v-if="user.email_confirmed">
          <i class="fal fa-check-circle text--success"/>
        </span>
        <span v-else>
          <i class="fal fa-times-circle text--warning"/>
        </span>
      </div>
      <div v-if="userIsNotAdmin">
        <span class="card__label">Contact</span>
        <span v-if="user.contact_confirmed">
          <i class="fal fa-check-circle text--success"/>
        </span>
        <span v-else>
          <i class="fal fa-times-circle text--warning"/>
        </span>
      </div>
      <div v-if="userIsNotAdmin">
        <span class="card__label">Société</span>
        <span v-if="user.company_confirmed">
          <i class="fal fa-check-circle text--success"/>
        </span>
        <span v-else>
          <i class="fal fa-times-circle text--warning"/>
        </span>
      </div>
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Créé</span>
        {{ getDate(user.created_at) }}
      </div>
      <div>
        <span class="card__label">Modifié</span>
        {{ getDate(user.updated_at) }}
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
