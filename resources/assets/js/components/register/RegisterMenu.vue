<template>
    <div>
        <a href="/">
            <div class="company-logo-container" :class="logo" aria-hidden="true"></div>
        </a>
        <div class="row">

            <!--Loader-->
            <app-moon-loader :loading="loader.loading"
                             :color="loader.color"
                             :size="loader.size">
            </app-moon-loader>

            <!--Show the carousel-->
            <app-register-carousel></app-register-carousel>

            <div class="col-12 col-lg-6 vh-100 d-flex align-items-center">
                <div class="col-12 col-lg-8 offset-lg-2">

                    <h4 class="text-center mb-5">Je souhaite créer un compte et</h4>

                    <div class="card card-custom bg-red hoverable hoverable-red"
                         @click="joinCompany">
                        <div class="card-block">
                            <h5 class="card-title-white">Je désire rejoindre ma société</h5>
                        </div>
                    </div>

                    <div class="card card-custom bg-purple hoverable hoverable-purple"
                         @click="addCompany">
                        <div class="card-block">
                            <h5 class="card-title-white">Je désire enregistrer ma société</h5>
                        </div>
                    </div>

                    <div class="card card-custom bg-orange hoverable hoverable-orange"
                         @click="asSelf">
                        <div class="card-block">
                            <h5 class="card-title-white">Je désire commander en mon nom propre</h5>
                        </div>
                    </div>

                    <p class="text-small text-center mt-5">
                        Vous disposez déjà d'un compte?
                        <a href="/login" class="ml-3">Connectez-vous</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import RegisterCarousel from './RegisterCarousel.vue'
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
    import mixins from '../../mixins'

    export default {
        components: {
            'app-register-carousel': RegisterCarousel,
            'app-moon-loader': MoonLoader
        },
        mixins: [mixins],
        methods: {

            /**
             * Create an account and join an existing company.
             */
            joinCompany() {
                this.$emit('registrationSelection', 'join')
            },

            /**
             * Create an account an create a new company.
             */
            addCompany() {
                this.$emit('registrationSelection', 'add')
            },

            /**
             * Create an account not linked with any company.
             */
            asSelf() {
                this.$emit('registrationSelection', 'self')
            }
        }
    }
</script>
