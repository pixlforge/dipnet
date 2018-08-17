<template>
  <div>
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <div class="card__details card__details--contact">
      <span>
        <strong>{{ contact.name | capitalize }}</strong>
      </span>
    </div>

    <div class="card__details card__details--contact">
      <div>{{ contact.address_line1 | capitalize }}</div>
      <div>{{ contact.address_line2 | capitalize }}</div>
    </div>

    <div class="card__details card__details--contact">
      <span>{{ contact.zip }} {{ contact.city }}</span>
    </div>

    <div class="card__details card__details--contact">
      <span v-if="contact.company">{{ contact.company.name }}</span>
    </div>

    <div class="card__details card__details--contact">
      <div v-if="contact.phone_number">Tel: {{ contact.phone_number }}</div>
      <div v-if="contact.fax">Fax: {{ contact.fax }}</div>
      <div>Email: {{ contact.email }}</div>
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
