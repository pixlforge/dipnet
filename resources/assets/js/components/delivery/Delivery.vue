<template>
  <div>
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <!-- Reference -->
    <div class="card__details card__details--delivery">
      <h5 class="model__label">Référence</h5>
      <span>
        <strong>{{ delivery.reference }}</strong>
      </span>
    </div>

    <!-- Note -->
    <div class="card__details card__details--delivery">
      <template v-if="delivery.note">
        <h5 class="model__label">Note</h5>
        <span>{{ deliveryNote }}</span>
      </template>
    </div>

    <!-- Order reference -->
    <div class="card__details card__details--delivery">
      <h5 class="model__label">Commande réf.</h5>
      <span>{{ delivery.order.reference }}</span>
    </div>

    <!-- Delivery contact -->
    <div class="card__details card__details--delivery">
      <h5 class="model__label">Livraison</h5>
      <span v-if="delivery.contact">{{ delivery.contact.name }}</span>
      <span v-else>Récupérer sur place</span>
    </div>

    <!-- Delivery date -->
    <div class="card__details card__details--delivery">
      <h5 class="model__label">Date de livraison</h5>
      <span v-if="delivery.to_deliver_at">{{ getDate(delivery.to_deliver_at) }}</span>
      <span v-else>Livraison éclair</span>
    </div>
  </div>
</template>

<script>
import { dates } from "../../mixins";

export default {
  mixins: [dates],
  props: {
    delivery: {
      type: Object,
      required: true
    }
  },
  computed: {
    deliveryNote() {
      if (this.delivery.note) {
        if (this.delivery.note.length > 45) {
          return this.delivery.note.substr(0, 45) + "...";
        } else {
          return this.delivery.note;
        }
      }
    }
  }
};
</script>