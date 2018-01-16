<template>
  <div>
    <div class="card__img">
      <img src="/img/placeholders/contact-bullet.jpg"
           alt="Bullet point image">
    </div>

    <div class="card__title">
      {{ invitation.email}}
    </div>

    <div class="card__meta">
      <app-resend-invitation :data-invitation="invitation">
      </app-resend-invitation>
    </div>

    <div class="card__controls">
      <div @click="destroy">
        <i class="fal fa-times"></i>
      </div>
    </div>
  </div>
</template>

<script>
  import ResendInvitation from './ResendInvitation.vue'
  import mixins from '../../mixins'

  export default {
    props: ['invitation'],
    components: {
      'app-resend-invitation': ResendInvitation
    },
    mixins: [mixins],
    methods: {
      /**
       * Delete an invitation.
       */
      destroy() {
        axios.delete(route('invitation.destroy', [this.invitation.id]))
          .then(() => {
            this.$emit('invitationWasDeleted', this.invitation.id)
            flash({
              message: "L'invitation a bien été annulée.",
              level: 'success'
            })
          })
          .catch(() => {
            flash({
              message: "L'invitation n'a pas été annulée. Une erreur s'est produite.",
              level: 'danger'
            })
          })
      }
    }
  }
</script>
