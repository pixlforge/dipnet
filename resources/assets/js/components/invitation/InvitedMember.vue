<template>
  <div>
    <div class="card__img">
      <img
        src="/img/placeholders/contact-bullet.jpg"
        alt="Bullet point image">
    </div>

    <div class="card__title">
      {{ invitation.email }}
    </div>

    <div class="card__meta">
      <resend-invitation :invitation="invitation"/>
    </div>

    <div class="card__controls">
      <div
        role="button"
        @click="destroy">
        <i class="fal fa-times"/>
      </div>
    </div>
  </div>
</template>

<script>
import ResendInvitation from "./ResendInvitation.vue";
import mixins from "../../mixins";

export default {
  components: {
    ResendInvitation
  },
  mixins: [mixins],
  props: {
    invitation: {
      type: Object,
      required: true
    }
  },
  methods: {
    destroy() {
      window.axios
        .delete(window.route("invitation.destroy", [this.invitation.id]))
        .then(() => {
          this.$emit("invitationWasDeleted", this.invitation.id);
          window.flash({
            message: "L'invitation a bien été annulée.",
            level: "success"
          });
        })
        .catch(() => {
          window.flash({
            message:
              "L'invitation n'a pas été annulée. Une erreur s'est produite.",
            level: "danger"
          });
        });
    }
  }
};
</script>
