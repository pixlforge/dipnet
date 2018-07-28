<template>
  <div>
    <button
      role="button"
      class="btn btn--warning"
      @click.prevent="sendConfirmationAgain">
      <i class="fal fa-redo"/>
      Renvoyer l'email de confirmation
    </button>
  </div>
</template>

<script>
import { mapActions } from "vuex";

export default {
  methods: {
    ...mapActions(["toggleLoader"]),
    async sendConfirmationAgain() {
      this.toggleLoader();

      try {
        await window.axios.put(window.route("register.confirm.update"));
        this.toggleLoader();
        window.flash({
          message: "L'email de confirmation vous a été envoyé à nouveau.",
          level: "success"
        });
      } catch (err) {
        this.toggleLoader();
        window.flash({
          message:
            "Il y a eu un problème avec le renvoi de l'email de confirmation",
          level: "danger"
        });
      }
    }
  }
};
</script>
