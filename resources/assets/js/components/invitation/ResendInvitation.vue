<template>
  <button class="btn btn--red"
          @click="resend">
    <i class="fal fa-redo"></i>
    Renvoyer
  </button>
</template>

<script>
  import mixins from '../../mixins'
  import { mapActions } from 'vuex'

  export default {
    props: ['data-invitation'],
    data() {
      return {
        invitation: this.dataInvitation
      }
    },
    mixins: [mixins],
    methods: {
      ...mapActions([
        'toggleLoader'
      ]),

      /**
       * Resend an existing invitation.
       */
      resend() {
        this.$store.dispatch('toggleLoader')

        axios.put(route('invitation.update'), this.invitation)
          .then(() => {
            this.$store.dispatch('toggleLoader')
            flash({
              message: `L'invitation a bien été renvoyée à l'adresse ${this.invitation.email}`,
              level: 'success'
            })
          })
          .catch(error => {
            this.$store.dispatch('toggleLoader')
            console.log(error.response.data)
          })
      }
    }
  }
</script>
