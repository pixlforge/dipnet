<template>
    <div class="container-fluid">
        <transition name="fade" mode="out-in">
            <app-register-menu v-if="showRegistrationMenu"
                               @registrationSelection="selection"></app-register-menu>

            <app-register-account v-if="showAccountForm"
                                  @accountCreated="accountCreated"></app-register-account>

            <app-register-contact v-if="showContactForm"
                                  @contactCreated="contactCreated"></app-register-contact>

            <app-register-company v-if="showCompanyForm"></app-register-company>
        </transition>
    </div>
</template>

<script>
    import RegisterMenu from './RegisterMenu.vue';
    import RegisterAccount from './RegisterAccount.vue';
    import RegisterContact from './RegisterContact.vue';
    import RegisterCompany from './RegisterCompany.vue';
    import mixins from '../../mixins';

    export default {
        data() {
            return {
                showRegistrationMenu: true,
                showAccountForm: false,
                showContactForm: false,
                showCompanyForm: false,
                registrationType: '',
                invitationCode: ''
            };
        },
        components: {
            'app-register-menu': RegisterMenu,
            'app-register-account': RegisterAccount,
            'app-register-contact': RegisterContact,
            'app-register-company': RegisterCompany
        },
        mixins: [mixins],
        methods: {
            selection(event) {
                this.registrationType = event;

                if (event === 'add') {
                    this.showRegistrationMenu = false;
                    this.showAccountForm = true;
                }
            },
            accountCreated() {
                this.showAccountForm = false;
                this.showContactForm = true;
            },
            contactCreated() {
                this.showContactForm = false;
                this.showCompanyForm = true;
            }
        }
    }
</script>