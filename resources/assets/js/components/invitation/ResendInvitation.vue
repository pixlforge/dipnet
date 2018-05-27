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
import mixins from "../../mixins";
import { mapActions } from "vuex";

export default {
  mixins: [mixins],
  props: {
    invitation: {
      type: Object,
      required: true
    }
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    resend() {
      this.$store.dispatch("toggleLoader");
      window.axios
        .put(window.route("invitation.update"), this.invitation)
        .then(() => {
          this.$store.dispatch("toggleLoader");
          window.flash({
            message: `L'invitation a bien été renvoyée à l'adresse ${
              this.invitation.email
            }`,
            level: "success"
          });
        })
        .catch(() => {
          this.$store.dispatch("toggleLoader");
        });
    }
  }
};
</script>
