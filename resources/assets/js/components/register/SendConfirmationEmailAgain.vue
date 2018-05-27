<template>
  <div>
    <button
      class="btn btn--warning"
      role="button"
      @click="sendConfirmationAgain">
      <i class="fal fa-redo"/>
      Renvoyer l'email de confirmation
    </button>
  </div>
</template>

<script>
import mixins from "../../mixins";

export default {
  mixins: [mixins],
  methods: {
    sendConfirmationAgain() {
      this.$store.dispatch("toggleLoader");
      window.axios
        .put(window.route("register.confirm.update"))
        .then(() => {
          this.$store.dispatch("toggleLoader");
          window.flash({
            message: "L'email de confirmation vous a été envoyé à nouveau.",
            level: "success"
          });
        })
        .catch(() => {
          this.$store.dispatch("toggleLoader");
          window.flash({
            message:
              "Il y a eu un problème avec le renvoi de l'email de confirmation",
            level: "danger"
          });
        });
    }
  }
};
</script>
