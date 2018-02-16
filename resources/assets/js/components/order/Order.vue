<template>
  <div>
    <div class="card__img">
      <img src="/img/placeholders/contact-bullet.jpg"
           alt="Bullet point image">
    </div>

    <div class="card__title">
      <a :href="createRoute"
         v-if="order.status === 'incomplète'">
        {{ order.reference }}
      </a>
      <a :href="showRoute"
         v-if="order.status !== 'incomplète' && dataUserRole === 'utilisateur'">
        {{ order.reference }}
      </a>
      <a :href="adminRoute"
         v-if="order.status !== 'incomplète' && dataUserRole === 'administrateur'">
        {{ order.reference }}
      </a>
    </div>

    <div class="badge"
         :class="statusClass">
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
      <div v-if="order.status === 'incomplète'"
           title="Supprimer"
           @click="destroy">
        <i class="fal fa-times"></i>
      </div>
    </div>
  </div>
</template>

<script>
  import moment from 'moment'
  import mixins from '../../mixins'

  export default {
    props: {
      dataOrder: {
        type: Object,
        required: true
      },
      dataUserRole: {
        type: String,
        required: true
      }
    },
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
        return route('orders.complete.show', [this.order.reference])
      },

      adminRoute() {
        return route('orders.show', [this.order.reference])
      }
    },
    methods: {
      getDate(date) {
        return moment(date).locale(this.momentLocale).format(this.momentFormat)
      },

      destroy() {
        axios.delete(route('orders.destroy', [this.order.reference]))
          .then(() => this.$emit('orderWasDeleted', this.order))
      }
    }
  }
</script>
