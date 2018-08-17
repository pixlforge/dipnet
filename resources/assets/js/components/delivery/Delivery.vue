<template>
  <div>
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <div class="card__details card__details--delivery">
      <span>
        <strong>{{ delivery.reference }}</strong>
      </span>
    </div>

    <div class="card__details card__details--delivery">
      <span v-if="delivery.note">{{ deliveryNote }}</span>
    </div>

    <div class="card__details card__details--delivery">
      <span>Commande ref.: {{ delivery.order.reference }}</span>
    </div>

    <div class="card__details card__details--delivery">
      <span v-if="delivery.contact">Livraison: {{ delivery.contact.name }}</span>
    </div>

    <div class="card__details card__details--delivery">
      <span v-if="delivery.to_deliver_at">À livrer: {{ getDate(delivery.to_deliver_at) }}</span>
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
      if (this.delivery.note.length > 45) {
        return this.delivery.note.substr(0, 45) + "...";
      } else {
        return this.delivery.note;
      }
    }
  }
};
</script>