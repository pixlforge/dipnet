<template>
    <div>
        <div class="col-lg-1 hidden-md-down">
            <img src="/img/placeholders/contact-bullet.jpg" alt="Bullet" class="img-bullet">
        </div>

        <div class="col-12 col-lg-5">

            <!--Username-->
            <h5 class="mb-0" v-text="invitation.email"></h5>
        </div>

        <div class="col-12 col-lg-3">
            <app-resend-invitation :data-invitation="invitation"></app-resend-invitation>
        </div>

        <!--Controls-->
        <div class="col-12 col-lg-3 center-on-small-only text-lg-right">
            <div class="dropdown">
                <a class="btn btn-transparent btn-sm" type="button" id="dropdownMenuLink"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fal fa-ellipsis-v fa-lg" aria-hidden="true"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right"
                     aria-labelledby="dropdownMenuLink">

                    <!--Delete-->
                    <a class="dropdown-item text-danger" role="button" @click.prevent="destroy">
                        <i class="fal fa-times"></i>
                        <span class="ml-3">Supprimer</span>
                    </a>
                </div>
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
                this.toggleLoader()

                axios.delete('/invitation/' + this.invitation.id)
                    .then(() => {
                        this.toggleLoader()
                        this.$emit('invitationWasDeleted', this.invitation.id)
                        flash({
                            message: "L'invitation a bien été annulée.",
                            level: 'success'
                        })
                    })
                    .catch(() => {
                        this.toggleLoader()
                        flash({
                            message: "L'invitation n'a pas été annulée. Une erreur s'est produite.",
                            level: 'danger'
                        })
                    })
            }
        }
    }
</script>
