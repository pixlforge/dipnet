<template>
  <button
    class="btn btn--red"
    role="button"
    @click="resend">
    <i class="fal fa-redo"/>
    Renvoyer
  </button>
</template>

<script>
import { mapActions } from "vuex";

export default {
  props: {
    invitation: {
      type: Object,
      required: true
    }
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    async resend() {
      this.toggleLoader();
      try {
        await window.axios.put(
          window.route("invitation.update"),
          this.invitation
        );
        this.toggleLoader();
        window.flash({
          message: `L'invitation a bien été renvoyée à l'adresse ${
            this.invitation.email
          }`,
          level: "success"
        });
      } catch (err) {
        this.toggleLoader();
      }
    }
  }
};
</script>
