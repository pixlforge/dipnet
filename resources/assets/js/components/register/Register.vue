<template>
    <div class="container-fluid">
        <transition name="fade" mode="out-in">

            <!--Show the registration menu-->
            <app-register-menu v-if="showRegistrationMenu"
                               @registrationSelection="selection">
            </app-register-menu>

            <!--Show the user instructions about how to join his company-->
            <app-register-join-infos v-if="showJoinInfos"
                                     @backToMenu="backToMenu">
            </app-register-join-infos>

            <!--Register the account-->
            <app-register-account v-if="showAccountForm"
                                  @accountCreated="accountCreated"
                                  :data-invitation="invitation.data">
            </app-register-account>

            <!--Create a contact for the newly registered user-->
            <app-register-contact v-if="showContactForm"
                                  :data-registration-type="registrationType"
                                  :data-invitation="invitation"
                                  @contactCreated="contactCreated">
            </app-register-contact>

            <!--Create a company for the newly registered user-->
            <app-register-company v-if="showCompanyForm"
                                  @companyCreated="companyCreated">
            </app-register-company>
        </transition>

        <!--Loader-->
        <app-moon-loader :loading="loader.loading"
                         :color="loader.color"
                         :size="loader.size">
        </app-moon-loader>
    </div>
</template>

<script>
    import RegisterMenu from './RegisterMenu.vue'
    import RegisterJoinInfos from './RegisterJoinInfos.vue'
    import RegisterAccount from './RegisterAccount.vue'
    import RegisterContact from './RegisterContact.vue'
    import RegisterCompany from './RegisterCompany.vue'
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
    import mixins from '../../mixins'

    export default {
        props: ['token-data'],
        data() {
            return {
                showRegistrationMenu: false,
                showJoinInfos: false,
                showAccountForm: false,
                showContactForm: false,
                showCompanyForm: false,
                registrationType: '',
                token: {
                    value: this.tokenData
                },
                invitation: {
                    data: {}
                }
            }
        },
        components: {
            'app-register-menu': RegisterMenu,
            'app-register-join-infos': RegisterJoinInfos,
            'app-register-account': RegisterAccount,
            'app-register-contact': RegisterContact,
            'app-register-company': RegisterCompany,
            'app-moon-loader': MoonLoader
        },
        mixins: [mixins],
        created() {

            /**
             * Get the invitation token and try to confirm it.
             */
            if (this.token.value) {
                this.registrationType = 'join'
                this.toggleLoader()

                axios.post('/invitation/confirm', this.token)
                    .then(response => {
                        this.invitation.data = response.data
                        this.showAccountForm = true
                        this.toggleLoader()
                    })
                    .catch(error => {
                        this.toggleLoader()
                    })
            } else {
                this.showRegistrationMenu = true
            }
        },
        methods: {

            /**
             * Registration selection type.
             */
            selection(event) {
                this.registrationType = event
                this.showRegistrationMenu = false
                if (this.registrationType === 'join') {
                    this.showJoinInfos = true
                } else {
                    this.showAccountForm = true
                }
            },

            /**
             * Account was created.
             */
            accountCreated() {
                this.showAccountForm = false
                this.showContactForm = true
            },

            /**
             * Contact was created.
             */
            contactCreated() {
                if (this.registrationType === 'add') {
                    this.showContactForm = false
                    this.showCompanyForm = true
                }
                if (this.registrationType === 'self' || this.registrationType === 'join') {
                    this.finishRegistration()
                }
            },

            /**
             * Company was created.
             */
            companyCreated() {
                this.finishRegistration()
            },

            /**
             * Get the user back to the menu.
             */
            backToMenu() {
                this.showJoinInfos = false
                this.showRegistrationMenu = true
            }
        }
    }
</script>
