<template>
  <a
    :href="orderRoute"
    class="card__container">
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <!-- Reference -->
    <div class="card__details card__details--order">
      <h5 class="model__label">Référence</h5>
      <span>
        {{ order.reference }}
      </span>
    </div>

    <!-- Status -->
    <div class="card__details card__details--order">
      <span
        :class="statusClass"
        class="badge">
        {{ order.status | capitalize }}
      </span>
    </div>

    <!-- Business -->
    <div class="card__details card__details--order">
      <template v-if="order.business">
        <h5 class="model__label">Affaire</h5>
        <span>{{ order.business.name }}</span>
      </template>
    </div>

    <!-- Username -->
    <div class="card__details card__details--order">
      <h5 class="model__label">Auteur</h5>
      <span>{{ order.user.username }}</span>
    </div>

    <div class="card__details card__details--order">
      <h5 class="model__label">Créé le</h5>
      <span>{{ getDate(order.created_at) }}</span>
    </div>

    <!-- Controls -->
    <div class="card__controls card__controls--order">
      <Button
        v-if="order.status === 'incomplète'"
        title="Supprimer"
        @click.prevent="destroy">
        <i class="fal fa-times"/>
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
    order: {
      type: Object,
      required: true
    },
    userRole: {
      type: String,
      required: false,
      default: () => {
        return "";
      }
    },
    displayUser: {
      type: Boolean,
      required: false,
      default: () => {
        return false;
      }
    }
  },
  computed: {
    statusClass() {
      if (this.order.status === "incomplète") return "badge--danger";
      if (this.order.status === "envoyée") return "badge--warning";
      if (this.order.status === "traitée") return "badge--success";
    },
    createRoute() {
      return window.route("orders.create.end", [this.order.reference]);
    },
    showRoute() {
      return window.route("orders.complete.show", [this.order.reference]);
    },
    adminRoute() {
      return window.route("admin.orders.show", [this.order.reference]);
    },
    orderRoute() {
      if (this.userRole === "administrateur") {
        return this.adminRoute;
      } else if (this.order.status !== "incomplète") {
        return this.showRoute;
      } else if (this.order.status === "incomplète") {
        return this.createRoute;
      }
    }
  },
  methods: {
    destroy() {
      window.axios
        .delete(window.route("orders.destroy", [this.order.reference]))
        .then(() => {
          this.$emit("orderWasDeleted", this.order);
        });
    }
  }
};
</script>
