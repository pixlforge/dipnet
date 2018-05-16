<template>
  <button class="btn btn--red"
          role="button"
          @click="resend">
    <i class="fal fa-redo"></i>
    Renvoyer
  </button>
</template>

<script>
  import mixins from '../../mixins'
  import { mapActions } from 'vuex'

  export default {
    props: {
      invitation: {
        type: Object,
        required: true
      }
    },
    mixins: [mixins],
    methods: {
      ...mapActions([
        'toggleLoader'
      ]),
      resend() {
        this.$store.dispatch('toggleLoader')
        axios.put(route('invitation.update'), this.invitation).then(() => {
          this.$store.dispatch('toggleLoader')
          flash({
            message: `L'invitation a bien été renvoyée à l'adresse ${this.invitation.email}`,
            level: 'success'
          })
        }).catch(error => {
          this.$store.dispatch('toggleLoader')
          console.log(error.response.data)
        })
      }
    }
  }
</script>
