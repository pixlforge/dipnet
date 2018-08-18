<template>
  <div>
    <div class="invitation__input-group">
      <div class="invitation__img">
        <img
          src="/img/placeholders/contact-bullet.jpg"
          alt="Bullet"
          class="img-bullet">
      </div>

      <input
        id="email"
        v-model="invitation.email"
        type="email"
        name="email"
        class="invitation__input"
        placeholder="adresse@email.tld"
        @keyup.enter="sendInvitation">
      <div
        v-if="errors.email"
        class="invitation__alert">
        {{ errors.email[0] }}
      </div>
    </div>

    <!-- Send -->
    <Button
      primary
      red
      @click="sendInvitation">
      <i class="fal fa-user-plus"/>
      Envoyer une invitation
    </Button>
  </div>
</template>

<script>
import Button from "../buttons/Button";

import { mapActions } from "vuex";

export default {
  components: {
    Button
  },
  data() {
    return {
      invitation: {
        email: ""
      },
      errors: {}
    };
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    async sendInvitation() {
      this.toggleLoader();
      try {
        let res = await window.axios.post(
          window.route("invitation.store"),
          this.invitation
        );
        this.toggleLoader();
        this.$emit("invitation:created", res.data);
        this.invitation = {};
      } catch (err) {
        this.errors = err.response.data.errors;
        this.toggleLoader();
      }
    }
  }
};
</script>
