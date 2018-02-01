<template>
  <div>
    <div class="card__img">
      <img src="/img/placeholders/contact-bullet.jpg"
           alt="Bullet point image">
    </div>

    <div class="card__title">
      {{ delivery.reference }}
    </div>

    <div class="card__meta">
      <div v-if="delivery.note">
        {{ deliveryNote }}
      </div>
    </div>

    <div class="card__meta">
      <div v-if="delivery.order">
        <span class="card__label">Commande</span>
        {{ delivery.order.reference }}
      </div>
      <div v-if="delivery.order">
        <span class="card__label">Contact</span>
        {{ delivery.contact.name}}
      </div>
      <div v-if="delivery.to_delivery_at">
        <span class="card__label">Date</span>
        {{ getDate(delivery.to_deliver_at) }}
      </div>
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Créé</span>
        {{ getDate(delivery.created_at) }}
      </div>
      <div>
        <span class="card__label">Modifié</span>
        {{ getDate(delivery.updated_at) }}
      </div>
    </div>
  </div>
</template>

<script>
  import moment from 'moment'
  import mixins from '../../mixins'

  export default {
    props: ['data-delivery'],
    data() {
      return {
        delivery: this.dataDelivery
      }
    },
    mixins: [mixins],
    computed: {
      deliveryNote() {
        if (this.delivery.note.length > 45) {
          return this.delivery.note.substr(0, 45) + '...'
        } else {
          return this.delivery.note
        }
      }
    },
    methods: {
      /**
       * Get the formatted dates.
       */
      getDate(date) {
        return moment(date).locale(this.momentLocale).format(this.momentFormat)
      },
    }
  }
</script>