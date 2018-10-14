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
    <div class="card__details card__details--contact">
      <h5 class="model__label">Nom</h5>
      <span>
        <strong>{{ contact.name | capitalize }}</strong>
      </span>
    </div>

    <!-- Address -->
    <div class="card__details card__details--contact">
      <h5 class="model__label">Adresse</h5>
      <div>{{ contact.address_line1 | capitalize }}</div>
      <div>{{ contact.address_line2 | capitalize }}</div>
    </div>

    <!-- Zip & City -->
    <div class="card__details card__details--contact">
      <h5 class="model__label">NPA &amp; Localité</h5>
      <span>{{ contact.zip }} {{ contact.city }}</span>
    </div>

    <!-- Company -->
    <div
      v-if="user.role === 'administrateur'"
      class="card__details card__details--contact">
      <template v-if="contact.company">
        <h5 class="model__label">Société</h5>
        <span>{{ contact.company.name }}</span>
      </template>
    </div>

    <!-- Phone, fax & email -->
    <div class="card__details card__details--contact">
      <h5 class="model__label">Coordonnées</h5>
      <div v-if="contact.phone_number">
        <i class="fal fa-phone fa-sm mr-2"/>
        {{ contact.phone_number }}
      </div>
      <div v-show="contact.email">
        <i class="fal fa-envelope fa-sm mr-2"/>
        {{ contact.email }}
      </div>
      <div v-if="!contact.phone_number && !contact.email">
        &mdash;
      </div>
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
import Button from "../buttons/Button";

import { filters, dates } from "../../mixins";

export default {
  components: {
    Button
  },
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
    },
    url() {
      return window.route("contacts.show", [this.contact.id]);
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
