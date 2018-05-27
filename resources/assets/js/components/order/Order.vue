<template>
  <div>
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <div class="card__title">
      <a
        v-if="order.status === 'incomplète'"
        :href="createRoute">
        {{ order.reference }}
      </a>
      <a
        v-if="order.status !== 'incomplète' && userRole === 'utilisateur'"
        :href="showRoute">
        {{ order.reference }}
      </a>
      <a
        v-if="order.status !== 'incomplète' && userRole === 'administrateur'"
        :href="adminRoute">
        {{ order.reference }}
      </a>
    </div>

    <div
      :class="statusClass"
      class="badge">
      {{ order.status | capitalize }}
    </div>

    <div class="card__meta">
      <div v-if="order.business">
        <span class="card__label">Affaire</span>
        {{ order.business.name }}
      </div>
      <div v-if="order.contact">
        <span class="card__label">Facturation</span>
        {{ order.contact.name }}
      </div>
    </div>

    <div class="card__meta">
      <span class="card__label">Par</span>
      {{ order.user.username }}
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Créé</span>
        {{ getDate(order.created_at) }}
      </div>
      <div>
        <span class="card__label">Modifié</span>
        {{ getDate(order.updated_at) }}
      </div>
    </div>

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
import mixins from "../../mixins";

export default {
  mixins: [mixins],
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
