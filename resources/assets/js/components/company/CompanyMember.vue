<template>
  <div class="card__container">
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <div class="card__details card__details--member">
      <h5 class="model__label">Nom d'utilisateur</h5>
      <span>
        <strong>{{ user.username }}</strong>
      </span>
    </div>

    <div class="card__details card__details--member">
      <h5 class="model__label">Adresse e-mail</h5>
      <span>{{ user.email }}</span>
    </div>

    <div class="card__details"/>
  </div>
</template>

<script>
import SendConfirmationEmailAgain from "../register/SendConfirmationEmailAgain.vue";

export default {
  components: {
    SendConfirmationEmailAgain
  },
  props: {
    user: {
      type: Object,
      required: true
    }
  },
  methods: {
    destroy() {
      alert("delete user");
    }
  }
};
</script>