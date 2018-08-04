<template>
  <div>
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <div class="card__title">
      {{ contact.name | capitalize }}
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Adresse</span>
        {{ contact.address_line1 | capitalize }}
      </div>
      <div>
        {{ contact.address_line2 | capitalize }}
      </div>
      <div>
        <span class="card__label">Localité</span>
        {{ contact.zip }} {{ contact.city }}
      </div>
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Tel</span>
        {{ contact.phone_number }}
      </div>
      <div>
        <span class="card__label">Fax</span>
        {{ contact.fax }}
      </div>
      <div>
        <span class="card__label">Email</span>
        {{ contact.email }}
      </div>
      <div v-if="contact.company">
        <span class="card__label">Société</span>
        {{ contact.company.name }}
      </div>
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Créé</span>
        {{ getDate(contact.created_at) }}
      </div>
      <div>
        <span class="card__label">Modifié</span>
        {{ getDate(contact.updated_at) }}
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
    contact: {
      type: Object,
      required: true
    },
    companies: {
      type: Array,
      required: true
    },
    user: {
      type: Object,
      required: true
    }
  },
  computed: {
    userIsAdmin() {
      return this.user.role === "administrateur";
    },
    endpoint() {
      return this.userIsAdmin ? "admin.contacts.destroy" : "contacts.destroy";
    }
  },
  methods: {
    edit() {
      this.$emit("edit-contact:open", this.contact);
    },
    destroy() {
      window.axios.delete(window.route(this.endpoint, [this.contact.id]));
      this.$emit("contact:deleted", this.contact.id);
    }
  }
};
</script>
