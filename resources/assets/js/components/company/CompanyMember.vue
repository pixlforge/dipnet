<template>
  <div>
    <div class="card__img">
      <img src="/img/placeholders/contact-bullet.jpg"
           alt="Bullet point image">
    </div>

    <div class="card__title">
      {{ user.username }}
    </div>

    <div class="card__meta">
      <span class="card__label">Email</span>
      {{ user.email }}
    </div>

    <div class="card__meta"></div>

  </div>
</template>

<script>
  import SendConfirmationEmailAgain from '../register/SendConfirmationEmailAgain.vue'
  import mixins from '../../mixins'

  export default {
    props: ['member'],
    data() {
      return {
        user: this.member
      }
    },
    components: {
      'app-send-confirmation-email-again': SendConfirmationEmailAgain
    },
    mixins: [mixins],
    methods: {
      destroy() {
        alert('delete member')
      }
    }
  }
</script>