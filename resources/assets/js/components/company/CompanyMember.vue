<template>
  <div>
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <div class="card__title">
      {{ user.username }}
    </div>

    <div class="card__meta">
      <span class="card__label">Email</span>
      {{ user.email }}
    </div>

    <div class="card__meta"/>
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