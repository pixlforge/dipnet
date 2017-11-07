<template>
    <div class="col-12">
        <h3 class="light mt-4">Inviter un membre</h3>
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-center center-on-small-only mt-5">

            <div class="col-lg-9 d-flex flex-row justify-content-start pl-0 pt-1">
                <div class="col-lg-1 pl-0 pt-2">
                    <img src="/img/placeholders/contact-bullet.jpg" alt="Bullet" class="img-bullet">
                </div>

                <div class="col-lg-6 pl-0">
                    <form @submit.prevent>
                        <div class="form-group">
                            <input type="email"
                                   name="user.email"
                                   class="form-control"
                                   placeholder="e.g. adresse@email.com"
                                   v-model="invitation.email"
                                   @keyup.enter="sendInvitation">
                            <div class="help-block"
                                 v-if="errors.email"
                                 v-text="errors.email[0]">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-3 text-lg-right pr-0">

                <!--Button-->
                <a @click="sendInvitation" class="btn btn-lg btn-black" role="button">
                    <i class="fal fa-user-plus mr-2"></i>
                    Envoyer une invitation
                </a>
            </div>

            <!--Loader-->
            <app-moon-loader :loading="loader.loading"
                             :color="loader.color"
                             :size="loader.size">
            </app-moon-loader>
        </div>
    </div>
</template>

<script>
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
    import mixins from '../../mixins'

    export default {
        data() {
            return {
                invitation: {
                    email: ''
                },
                errors: {}
            }
        },
        components: {
            'app-moon-loader': MoonLoader
        },
        mixins: [mixins],
        methods: {

            /**
             * Add an invitation.
             */
            sendInvitation() {
                this.toggleLoader()

                axios.post('/invitation', this.invitation)
                    .then(response => {
                        this.toggleLoader()
                        this.$emit('invitationWasAdded', response.data)
                    })
                    .then(() => {
                        this.invitation = {}
                    })
                    .catch(error => {
                        this.toggleLoader()
                        this.errors = error.response.data.errors
                    })
            }
        }
    }
</script>
