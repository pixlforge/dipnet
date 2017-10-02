<template>
    <div class="container-fluid">

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
                    <form role="form"
                          @submit.prevent>

                        <h4 class="text-center">Votre Compte</h4>

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
                                @click="updateAccount">
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
    import RegisterCarousel from '../register/RegisterCarousel.vue';
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue';
    import mixins from '../../mixins';

    export default {
        data() {
            return {
                account: {
                    username: '',
                    password: '',
                    password_confirmation: ''
                },
                errors: {}
            };
        },
        components: {
            'app-register-carousel': RegisterCarousel,
            'app-moon-loader': MoonLoader
        },
        mixins: [mixins],
        methods: {
            updateAccount() {
                this.toggleLoader();

                axios.put('/invite/confirm', this.account)
                    .then(() => {
                        this.toggleLoader();
                        this.account = {};
                        flash({
                            message: 'Félicitations! Votre compte a bien été mis à jour!',
                            level: 'success'
                        });
                        setTimeout(() => {
                            window.location.pathname = '/';
                        }, 2000);
                    })
                    .catch(error => {
                        this.toggleLoader();
                        this.errors = error.response.data.errors;
                    });
            },
        }
    }
</script>