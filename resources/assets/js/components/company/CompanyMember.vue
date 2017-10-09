<template>
    <div>
        <div class="col-lg-1 hidden-md-down">
            <img src="/img/placeholders/contact-bullet.jpg" alt="Bullet" class="img-bullet">
        </div>

        <div class="col-12 col-lg-3">

            <!--Username-->
            <h5 class="mb-0" v-text="user.username"></h5>
        </div>

        <div class="col-12 col-lg-2">

            <!--Invitation was sent-->
            <span class="badge badge-custom badge-warning"
                  v-if="user.was_invited && ! user.confirmed"
                  v-text="'Invitation envoyée'">
            </span>
        </div>

        <div class="col-12 col-lg-3">

            <!--Email-->
            <span class="card-content" v-text="user.email"></span>
        </div>

        <div class="col-12 col-lg-2">

            <app-send-confirmation-email-again v-if="user.was_invited && ! user.confirmed">
                Renvoyer
            </app-send-confirmation-email-again>
        </div>

        <!--Controls-->
        <div class="col-12 col-lg-1 center-on-small-only text-lg-right">
            <div class="dropdown">
                <a class="btn btn-transparent btn-sm" type="button" id="dropdownMenuLink"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fal fa-ellipsis-v fa-lg" aria-hidden="true"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right"
                     aria-labelledby="dropdownMenuLink">

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
    import SendConfirmationEmailAgain from '../register/SendConfirmationEmailAgain.vue';
    import mixins from '../../mixins';

    export default {
        props: ['member'],
        data() {
            return {
                user: this.member
            };
        },
        components: {
            'app-send-confirmation-email-again': SendConfirmationEmailAgain
        },
        mixins: [mixins],
        methods: {
            destroy() {
                alert('delete member');
            }
        }
    }
</script>