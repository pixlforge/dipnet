<template>
    <div class="container-fluid">
        <transition name="fade" mode="out-in">

            <!--Account Section-->
            <div v-if="showAccountForm" key="account">
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

                                <h4 class="text-center">Enregistrement</h4>

                                <!--Username-->
                                <div class="form-group my-5">
                                    <label for="username">Nom d'utilisateur</label>
                                    <span class="required">requis</span>
                                    <input type="text"
                                           id="username"
                                           name="username"
                                           v-model="account.username"
                                           class="form-control"
                                           placeholder="e.g. John Doe"
                                           required autofocus>
                                    <div class="help-block"
                                         v-if="errors.username"
                                         v-text="errors.username[0]"></div>
                                </div>

                                <!--Email-->
                                <div class="form-group my-5">
                                    <label for="email">E-mail</label>
                                    <span class="required">requis</span>
                                    <input type="email"
                                           id="email"
                                           name="email"
                                           v-model="account.email"
                                           class="form-control"
                                           placeholder="e.g. votre@email.ch"
                                           required>
                                    <div class="help-block"
                                         v-if="errors.email"
                                         v-text="errors.email[0]"></div>
                                </div>

                                <!--Password-->
                                <div class="form-group my-5">
                                    <label for="password">Mot de passe</label>
                                    <span class="required">requis</span>
                                    <input type="password"
                                           id="password"
                                           name="password"
                                           v-model="account.password"
                                           class="form-control"
                                           placeholder="Entre 6 et 45 caractères"
                                           required>
                                    <div class="help-block"
                                         v-if="errors.password"
                                         v-text="errors.password[0]"></div>
                                </div>

                                <!--Password confirm-->
                                <div class="form-group my-5">
                                    <label for="password-confirm">Confirmation du mot de passe</label>
                                    <span class="required">requis</span>
                                    <input type="password"
                                           id="password-confirm"
                                           name="password_confirmation"
                                           v-model="account.password_confirmation"
                                           class="form-control"
                                           placeholder="Répétez votre mot de passe"
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

            <!--Details Section-->
            <div v-else key="details">

                <transition name="fade" mode="out-in">
                    <app-register-contact v-if="showContactForm"
                                          @contactWasUpdated="switchComponents"
                                          key="registerContactInfo">
                    </app-register-contact>

                    <app-register-company v-else
                                          @companyWasUpdated="redirectToHome"
                                          key="registerCompanyInfo">
                    </app-register-company>
                </transition>

            </div>
        </transition>
    </div>
</template>

<script>
    import RegisterCarousel from './RegisterCarousel.vue';
    import RegisterContact from './RegisterContact.vue';
    import RegisterCompany from './RegisterCompany.vue';
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue';
    import {eventBus} from '../app';

    export default {
        data() {
            return {
                account: {
                    username: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                },
                errors: {},
                showAccountForm: true,
                showContactForm: true,
                loader: {
                    color: '#fff',
                    size: '96px',
                    loading: false
                },
                appName: Laravel.appName
            }
        },
        components: {
            'app-register-carousel': RegisterCarousel,
            'app-register-contact': RegisterContact,
            'app-register-company': RegisterCompany,
            'app-moon-loader': MoonLoader
        },
        computed: {
            logo() {
                return this.appName === 'Dipnet' ? 'company-logo-dip' : 'company-logo-multicop';
            }
        },
        methods: {
            registerAccount() {
                this.toggleLoader();

                axios.post('/register', this.account)
                    .then(() => {
                        this.toggleLoader();
                        this.toggleModal();
                        this.account = {};
                        this.showAccountForm = false;
                    })
                    .catch(error => {
                        this.toggleLoader();
                        this.errors = error.response.data.errors;
                    });
            },
            toggleModal() {
                this.showModal === false ? this.showModal = true : this.showModal = false;
            },
            toggleLoader() {
                this.loader.loading = !this.loader.loading;
            },
            switchComponents() {
                this.showContactForm = !this.showContactForm;
            },
            redirectToHome() {
                flash({
                    message: 'Félicitations! Votre compte est fin prêt!',
                    level: 'success'
                });
                setTimeout(() => {
                    window.location.pathname = '/';
                }, 2000);
            }
        }
    }
</script>