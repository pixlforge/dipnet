<template>
  <div>
    <div class="col col-lg-1 hidden-md-down">
      <img src="/img/placeholders/contact-bullet.jpg"
           alt="Bullet"
           class="img-bullet">
    </div>

    <div class="col-12 col-lg-2">

      <!--Reference-->
      <h5 class="mb-0">
        <a :href="`/orders/${order.reference}/create`">
          {{ order.reference }}
        </a>
      </h5>
    </div>

    <div class="col-12 col-lg-2">

      <!--Status-->
      <div class="badge badge-custom"
            :class="statusClass"
            v-text="order.status">
      </div>
    </div>

    <div class="col-12 col-lg-3">

      <!--Business-->
      <div class="card-content"
           v-if="order.business">
        <span class="card-label">Affaire:</span>
        <span v-text="order.business.name"></span>
      </div>

      <!--Contact-->
      <div class="card-content"
           v-if="order.contact">
        <span class="card-label">Facturation:</span>
        <span v-text="order.contact.name"></span>
      </div>
    </div>

    <div class="col-12 col-lg-3">

      <!--Created at-->
      <div class="card-content">
        <span class="card-label">Créé:</span>
        <span v-text="getDate(order.created_at)"></span>
      </div>

      <!--Modified at-->
      <div class="card-content">
        <span class="card-label">Modifié:</span>
        <span v-text="getDate(order.updated_at)"></span>
      </div>
    </div>

    <div class="col-12 col-lg-1 center-on-small-only text-lg-right">
    </div>
  </div>
</template>

<script>
  import moment from 'moment'
  import mixins from '../../mixins'

  export default {
    props: ['data-order'],
    data() {
      return {
        order: this.dataOrder
      }
    },
    mixins: [mixins],
    computed: {
      statusClass() {
        if (this.order.status === 'incomplète') return 'badge--danger'
        if (this.order.status === 'réceptionnée') return 'badge--warning'
        if (this.order.status === 'traitée' || this.order.status === 'envoyée') return 'badge--success'
      }
    },
    methods: {
      getDate(date) {
        return moment(date).locale(this.momentLocale).format(this.momentFormat)
      }
    }
  }
</script>

<style scoped>
  a {
    color: inherit;
    text-decoration: none;
  }

  a:hover {
    text-decoration: underline;
  }
</style>
