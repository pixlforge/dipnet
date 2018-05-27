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

    <button
      class="btn btn--red"
      role="button"
      @click="sendInvitation">
      <i class="fal fa-user-plus"/>
      Envoyer une invitation
    </button>
  </div>
</template>

<script>
import mixins from "../../mixins";
import { mapActions } from "vuex";

export default {
  mixins: [mixins],
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
    sendInvitation() {
      this.$store.dispatch("toggleLoader");
      window.axios
        .post(window.route("invitation.store"), this.invitation)
        .then(response => {
          this.$store.dispatch("toggleLoader");
          this.$emit("invitationWasAdded", response.data);
        })
        .then(() => {
          this.invitation = {};
        })
        .catch(error => {
          this.$store.dispatch("toggleLoader");
          this.errors = error.response.data.errors;
        });
    }
  }
};
</script>
