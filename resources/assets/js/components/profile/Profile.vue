<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-10 my-5 mx-auto">
                <div class="row">
                    <div class="col-12 d-flex flex-column flex-lg-row justify-content-between align-items-center center-on-small-only">
                        <div>
                            <h1 class="mt-5 mb-0">
                                {{ user.username }}
                                <span class="profile-icon ml-3"
                                      title="Compte vérifié"
                                      v-if="user.confirmed">
                                    <i class="fa fa-check-circle text-info"></i>
                                </span>
                                <span class="profile-icon ml-3"
                                      title="Compte non vérifié"
                                      v-else>
                                    <i class="fa fa-exclamation-circle text-warning"></i>
                                </span>
                            </h1>
                            <h5 class="text-muted light ml-1">Votre profil</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row bg-grey-light">
            <div class="col-10 mx-auto my-7">
                <div class="card card-custom flex-column px-5">

                    <div class="profile-card-content">
                        {{ user.email }}
                    </div>

                    <div class="profile-card-content">
                        État du compte
                        <span class="text-info" v-if="user.confirmed">
                            vérifié
                        </span>
                        <span v-else>
                            <span class="text-warning">
                                e-mail envoyé
                            </span>
                            <app-send-confirmation-email-again class="mt-3">
                            </app-send-confirmation-email-again>
                        </span>
                    </div>

                    <div class="profile-card-content">
                        Membre de {{ user.company.name }}
                    </div>

                    <div class="profile-card-content">
                        <!--Contact principal {{ user.contact.name }}-->
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SendConfirmationEmailAgain from '../register/SendConfirmationEmailAgain.vue';
    import mixins from '../../mixins';

    export default {
        props: ['user-data'],
        data() {
            return {
                user: this.userData
            };
        },
        mixins: [mixins],
        components: {
            'app-send-confirmation-email-again': SendConfirmationEmailAgain
        }
    }
</script>