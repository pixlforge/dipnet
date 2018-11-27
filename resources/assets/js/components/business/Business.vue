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
    <div class="card__details card__details--business">
      <h5 class="model__label">Nom</h5>
      <span>
        <strong>{{ business.name | capitalize }}</strong>
      </span>
    </div>

    <!-- Reference -->
    <div class="card__details card__details--business">
      <h5 class="model__label">Référence</h5>
      <span>{{ business.reference }}</span>
    </div>

    <!-- Description -->
    <div class="card__details card__details--business">
      <template v-if="business.description">
        <h5 class="model__label">Description</h5>
        <span>{{ business.description | capitalize }}</span>
      </template>
    </div>

    <!-- Company -->
    <div class="card__details card__details--business">
      <template v-if="business.company">
        <h5 class="model__label">Société</h5>
        <span>{{ business.company.name | capitalize }}</span>
      </template>
    </div>

    <!-- Contact -->
    <div class="card__details card__details--business">
      <template v-if="business.contact">
        <h5 class="model__label">Contact</h5>
        <span>
          {{ contactName | capitalize }}
        </span>
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
        title="Supprimer"
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
  computed: {
    url() {
      return window.route("businesses.show", [this.business.reference]);
    },
    contactName() {
      let contact = this.business.contact;
      let fullName = contact.first_name;
      if (contact.last_name) {
        fullName += ` ${contact.last_name}`;
      }
      if (contact.company_name) {
        fullName += ` ${contact.company_name}`;
      }
      return fullName;
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
