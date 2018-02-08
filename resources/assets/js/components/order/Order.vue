<template>
  <div>
    <div class="card__img">
      <img src="/img/placeholders/contact-bullet.jpg"
           alt="Bullet point image">
    </div>

    <div class="card__title">
      <a :href="createRoute" v-if="order.status === 'incomplète'">
        {{ order.reference }}
      </a>
      <a :href="showRoute" v-else>
        {{ order.reference }}
      </a>
    </div>

    <div class="badge"
         :class="statusClass">
      {{ order.status | capitalize }}
    </div>

    <div class="card__meta" v-if="!displayUser">
      <div v-if="order.business">
        <span class="card__label">Affaire</span>
        {{ order.business.name }}
      </div>
      <div v-if="order.contact">
        <span class="card__label">Facturation</span>
        {{ order.contact.name }}
      </div>
    </div>

    <div class="card__meta" v-if="displayUser">
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
  </div>
</template>

<script>
  import moment from 'moment'
  import mixins from '../../mixins'

  export default {
    props: [
      'data-order',
      'display-user'
    ],
    data() {
      return {
        order: this.dataOrder
      }
    },
    mixins: [mixins],
    computed: {
      statusClass() {
        if (this.order.status === 'incomplète') return 'badge--danger'
        if (this.order.status === 'envoyée') return 'badge--warning'
        if (this.order.status === 'traitée') return 'badge--success'
      },

      createRoute() {
        return route('orders.create.end', [this.order.reference])
      },

      showRoute() {
        return route('orders.show', [this.order.reference])
      }
    },
    methods: {
      getDate(date) {
        return moment(date).locale(this.momentLocale).format(this.momentFormat)
      }
    }
  }
</script>
