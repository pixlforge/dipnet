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
                                      v-if="user.email_confirmed">
                                    <i class="fal fa-check-circle text-success"></i>
                                </span>
                                <span class="profile-icon ml-3"
                                      title="Compte non vérifié"
                                      v-else>
                                    <i class="fal fa-times-circle text-warning"></i>
                                </span>
                            </h1>
                        </div>

                        <div class="d-flex">
                            <app-send-confirmation-email-again v-if="!user.email_confirmed"></app-send-confirmation-email-again>
                            <app-update-profile :data-user="user"
                                                :data-avatar="avatar"
                                                :data-random-avatar="dataRandomAvatar"></app-update-profile>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row bg-grey-light">
            <div class="col-10 mx-auto my-7">
                <div class="card card-custom">

                    <div class="row w-100">
                        <div class="col-12 col-lg-4 py-4 px-6">
                            <img :src="avatar"
                                 class="img-fluid"
                                 alt="Avatar"
                                 v-if="avatar">

                            <img :src="randomAvatarPath"
                                 class="img-fluid"
                                 alt="Avatar"
                                 v-else>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="my-4">
                                <h3 class="bold">Adresse e-mail</h3>
                                <p class="profile-data">
                                    {{ user.email }}
                                </p>
                            </div>

                            <div class="my-4">
                                <h3 class="bold">Création de compte</h3>
                                <p class="profile-data">
                                    {{ getDate(user.created_at) }}
                                </p>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="my-4">
                                <h3 class="bold">Membre de</h3>
                                <p class="profile-data">
                                    {{ user.company.name }}
                                </p>
                            </div>

                            <div class="my-4">
                                <h3 class="bold">Réalisation de</h3>
                                <p class="profile-data">
                                    <span v-if="orders == 0">Aucune commande</span>
                                    <span v-if="orders == 1">{{ orders }} commande</span>
                                    <span v-if="orders > 1"> {{ orders }} commandes</span>
                                </p>
                            </div>

                            <div class="my-4">
                                <h3 class="bold">Participe à</h3>
                                <p class="profile-data">
                                    <span v-if="businesses == 0">Aucune affaire</span>
                                    <span v-if="businesses == 1">{{ businesses }} affaire</span>
                                    <span v-if="businesses > 1"> {{ businesses }} affaires</span>
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SendConfirmationEmailAgain from '../register/SendConfirmationEmailAgain.vue';
    import UpdateProfile from './UpdateProfile.vue';
    import moment from 'moment';
    import mixins from '../../mixins';

    export default {
        props: [
            'data-user',
            'data-orders',
            'data-businesses',
            'data-avatar',
            'data-random-avatar'
        ],
        data() {
            return {
                avatar: this.dataAvatar,
                user: this.dataUser,
                orders: this.dataOrders,
                businesses: this.dataBusinesses
            };
        },
        computed: {
            randomAvatarPath() {
                return 'img/placeholders/' + this.dataRandomAvatar;
            }
        },
        mixins: [mixins],
        components: {
            'app-send-confirmation-email-again': SendConfirmationEmailAgain,
            'app-update-profile': UpdateProfile
        },
        methods: {
            getDate(date) {
                return moment(date).locale(this.momentLocale).format(this.momentFormat);
            }
        }
    }
</script>