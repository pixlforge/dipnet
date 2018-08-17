<template>
  <div>
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <!-- Reference -->
    <div class="card__details card__details--order">
      <a :href="orderRoute">
        <strong>{{ order.reference }}</strong>
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
      <span v-if="order.business">Affaire: {{ order.business.name }}</span>
    </div>

    <!-- Contact -->
    <div class="card__details card__details--order">
      <span v-if="order.contact">Facturation: {{ order.contact.name }}</span>
    </div>

    <!-- Username -->
    <div class="card__details card__details--order">
      <span>Par: {{ order.user.username }}</span>
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
      return window.route("orders.show", [this.order.reference]);
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
