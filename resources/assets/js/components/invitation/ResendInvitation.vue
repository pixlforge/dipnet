<template>
  <Button
    primary
    orange
    small
    @click.prevent="resend">
    <i class="fal fa-redo"/>
    Renvoyer
  </Button>
</template>

<script>
import Button from "../buttons/Button";

import { mapActions } from "vuex";

export default {
  components: {
    Button
  },
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
