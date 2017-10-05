<template>
    <div>
        <a href="/">
            <div class="company-logo-container" :class="logo" aria-hidden="true"></div>
        </a>
        <div class="row">

            <app-register-carousel></app-register-carousel>

            <div class="col-12 col-lg-6 vh-100 d-flex align-items-center">
                <div class="col-12 col-lg-8 offset-lg-2">

                    <!--Loader-->
                    <app-moon-loader :loading="loader.loading"
                                     :color="loader.color"
                                     :size="loader.size"></app-moon-loader>

                    <!--Register Account Form-->
                    <form role="form" @submit.prevent>

                        <h4 class="text-center">Enregistrement</h4>

                        <!--Username-->
                        <div class="form-group my-5">
                            <label for="username">Nom d'utilisateur</label>
                            <span class="required">*</span>
                            <input type="text"
                                   id="username"
                                   name="username"
                                   v-model="account.username"
                                   class="form-control"
                                   required autofocus>
                            <div class="help-block"
                                 v-if="errors.username"
                                 v-text="errors.username[0]"></div>
                        </div>

                        <!--Email-->
                        <div class="form-group my-5">
                            <label for="email">E-mail</label>
                            <span class="required">*</span>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   v-model="account.email"
                                   class="form-control"
                                   :disabled="invitation.data.email"
                                   required>
                            <div class="help-block"
                                 v-if="errors.email"
                                 v-text="errors.email[0]"></div>
                        </div>

                        <!--Password-->
                        <div class="form-group my-5">
                            <label for="password">Mot de passe</label>
                            <span class="required">*</span>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   v-model="account.password"
                                   class="form-control"
                                   required>
                            <div class="help-block"
                                 v-if="errors.password"
                                 v-text="errors.password[0]"></div>
                        </div>

                        <!--Password confirm-->
                        <div class="form-group my-5">
                            <label for="password-confirm">Confirmation du mot de passe</label>
                            <span class="required">*</span>
                            <input type="password"
                                   id="password-confirm"
                                   name="password_confirmation"
                                   v-model="account.password_confirmation"
                                   class="form-control"
                                   required>
                        </div>

                        <button class="btn btn-black btn-block mt-5"
                                @click="registerAccount">
                            Créer le compte
                        </button>

                        <p class="text-small text-center mt-4">
                            Vous disposez déjà d'un compte?
                            <a href="/login" class="ml-3">Connectez-vous</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import RegisterCarousel from './RegisterCarousel.vue';
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue';
    import mixins from '../../mixins';

    export default {
        props: ['data-invitation'],
        data() {
            return {
                account: {
                    username: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                },
                errors: {},
                invitation: {
                    data: this.dataInvitation
                }
            }
        },
        components: {
            'app-register-carousel': RegisterCarousel,
            'app-moon-loader': MoonLoader
        },
        created() {
            if (this.invitation.data) {
                this.account.email = this.invitation.data.email;
            }
        },
        mixins: [mixins],
        methods: {
            registerAccount() {
                this.toggleLoader();

                axios.post('/register', this.account)
                    .then(() => {
                        this.toggleLoader();
                        this.toggleModal();
                        this.account = {};
                        this.$emit('accountCreated');
                    })
                    .catch(error => {
                        this.toggleLoader();
                        this.errors = error.response.data.errors;
                    });
            }
        }
    }
</script>