<template>
  <div>
    <transition name="fade" mode="out-in">
      <register-menu v-if="showRegistrationMenu"
                     :app-name="appName"
                     @registrationSelection="selection"></register-menu>
      <register-join-infos v-if="showJoinInfos"
                           @backToMenu="backToMenu"></register-join-infos>
      <register-account v-if="showAccountForm"
                        :registration-type="registrationType"
                        :invitation="invitation"
                        @accountCreated="accountCreated"></register-account>
      <register-contact v-if="showContactForm"
                        :registration-type="registrationType"
                        :invitation="invitation"
                        @contactCreated="contactCreated"></register-contact>
      <register-company v-if="showCompanyForm"
                        @companyCreated="companyCreated"></register-company>
    </transition>
    <moon-loader :loading="loaderState"
                 :color="loader.color"
                 :size="loader.size"></moon-loader>
  </div>
</template>

<script>
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import RegisterMenu from './RegisterMenu.vue'
  import RegisterJoinInfos from './RegisterJoinInfos.vue'
  import RegisterAccount from './RegisterAccount.vue'
  import RegisterContact from './RegisterContact.vue'
  import RegisterCompany from './RegisterCompany.vue'
  import mixins from '../../mixins'
  import { mapGetters, mapActions } from 'vuex'

  export default {
    components: {
      MoonLoader,
      RegisterMenu,
      RegisterJoinInfos,
      RegisterAccount,
      RegisterContact,
      RegisterCompany
    },
    props: {
      token: {
        type: String,
        required: true
      }
    },
    data() {
      return {
        showRegistrationMenu: false,
        showJoinInfos: false,
        showAccountForm: false,
        showContactForm: false,
        showCompanyForm: false,
        registrationType: '',
        invitation: {}
      }
    },
    computed: {
      ...mapGetters([
        'loaderState'
      ])
    },
    mixins: [mixins],
    methods: {
      ...mapActions([
        'toggleLoader'
      ]),
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
    },
    created() {
      /**
       * Get the invitation token and try to confirm it.
       */
      if (this.token) {
        this.registrationType = 'join'
        this.$store.dispatch('toggleLoader')
        axios.post(route('invitation.confirm'), {
          token: this.token
        }).then(response => {
          this.invitation = response.data
          this.showAccountForm = true
          this.$store.dispatch('toggleLoader')
        }).catch(error => {
          this.$store.dispatch('toggleLoader')
        })
      } else {
        this.showRegistrationMenu = true
      }
    }
  }
</script>
