<template>
  <div>
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <!-- Reference -->
    <div class="card__details card__details--order">
      <h5 class="model__label">Référence</h5>
      <a :href="orderRoute">
        {{ order.reference }}
      </a>
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

    <!-- Contact -->
    <div class="card__details card__details--order">
      <template v-if="order.contact">
        <h5 class="model__label">Facturation</h5>
        <span>{{ order.contact.name }}</span>
      </template>
    </div>

    <!-- Username -->
    <div class="card__details card__details--order">
      <h5 class="model__label">Auteur</h5>
      <span>{{ order.user.username }}</span>
    </div>

    <!-- Controls -->
    <div class="card__controls card__controls--order">
      <div
        v-if="order.status === 'incomplète'"
        title="Supprimer"
        role="button"
        @click="destroy">
        <i class="fal fa-times"/>
      </div>
    </div>
  </div>
</template>

<script>
import { filters, dates } from "../../mixins";

export default {
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
