<template>
  <div class="mt-4 mr-3">
    <a class="btn btn-lg btn-orange"
       @click="sendConfirmationAgain">
      <i class="fal fa-redo mr-2"></i>
      Renvoyer l'email de confirmation
    </a>
  </div>
</template>

<script>
  import mixins from '../../mixins'
  import { mapActions } from 'vuex'

  export default {
    mixins: [mixins],
    methods: {
      ...mapActions([
        'toggleLoader'
      ]),

      /**
       * Send the confirmation email again.
       */
      sendConfirmationAgain() {
        this.$store.dispatch('toggleLoader')

        axios.put(route('register.confirm.update'))
          .then(() => {
            this.$store.dispatch('toggleLoader')
            flash({
              message: "L'email de confirmation vous a été envoyé à nouveau.",
              level: 'success'
            })
          })
          .catch(() => {
            this.$store.dispatch('toggleLoader')
            flash({
              message: "Il y a eu un problème avec le renvoi de l'email de confirmation",
              level: 'danger'
            })
          })
      }
    }
  }
</script>
