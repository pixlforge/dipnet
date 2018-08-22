<template>
  <div class="card__container">
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <!-- Email -->
    <div class="card__details card__details--invitation">
      <h5 class="model__label">Adresse e-mail</h5>
      <span>
        <strong>{{ invitation.email }}</strong>
      </span>
    </div>

    <!-- Resend invitation -->
    <div class="card__details card__details--invitation">
      <ResendInvitation :invitation="invitation"/>
    </div>

    <!-- Controls -->
    <div class="card__controls">
      <Button
        @click.prevent="destroy">
        <i class="fal fa-times"/>
      </Button>
    </div>
  </div>
</template>

<script>
import Button from "../buttons/Button";
import ResendInvitation from "./ResendInvitation.vue";

export default {
  components: {
    Button,
    ResendInvitation
  },
  props: {
    invitation: {
      type: Object,
      required: true
    }
  },
  methods: {
    async destroy() {
      try {
        await window.axios.delete(
          window.route("invitation.destroy", [this.invitation.id])
        );
        this.$emit("invitation:deleted", this.invitation.id);
        window.flash({
          message: "L'invitation a bien été annulée.",
          level: "success"
        });
      } catch (err) {
        window.flash({
          message:
            "L'invitation n'a pas été annulée. Une erreur s'est produite.",
          level: "danger"
        });
      }
    }
  }
};
</script>
