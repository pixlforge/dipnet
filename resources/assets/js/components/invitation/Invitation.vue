<template>
  <div>
    <div class="invitation__input-group">
      <div class="invitation__img">
        <img src="/img/placeholders/contact-bullet.jpg"
             alt="Bullet"
             class="img-bullet">
      </div>

      <input type="email"
             name="email"
             id="email"
             class="invitation__input"
             placeholder="adresse@email.tld"
             v-model="invitation.email"
             @keyup.enter="sendInvitation">
      <div class="invitation__alert"
           v-if="errors.email">
        {{ errors.email[0] }}
      </div>
    </div>

    <button class="btn btn--black"
            @click="sendInvitation">
      <i class="fal fa-user-plus"></i>
      Envoyer une invitation
    </button>
  </div>
</template>

<script>
  import mixins from '../../mixins'
  import { mapActions } from 'vuex'

  export default {
    data() {
      return {
        invitation: {
          email: ''
        },
        errors: {}
      }
    },
    mixins: [mixins],
    methods: {
      ...mapActions([
        'toggleLoader'
      ]),

      /**
       * Add an invitation.
       */
      sendInvitation() {
        this.$store.dispatch('toggleLoader')

        axios.post(route('invitation.store'), this.invitation)
          .then(response => {
            this.$store.dispatch('toggleLoader')
            this.$emit('invitationWasAdded', response.data)
          })
          .then(() => {
            this.invitation = {}
          })
          .catch(error => {
            this.$store.dispatch('toggleLoader')
            this.errors = error.response.data.errors
          })
      }
    }
  }
</script>
