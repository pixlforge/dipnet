<template>
  <div>
    <a href="/">
      <div class="company-logo-container"
           :class="logo"
           aria-hidden="true">
      </div>
    </a>
    <div class="row">

      <!--Show the carousel-->
      <app-register-carousel></app-register-carousel>

      <div class="col-12 col-lg-6 vh-100 d-flex align-items-center">
        <div class="col-12 col-lg-8 offset-lg-2">

          <!--Register Account Form-->
          <form role="form" @submit.prevent>

            <h4 class="text-center">Enregistrement</h4>

            <!--Username-->
            <div class="form-group my-5">
              <label for="username">Nom d'utilisateur / Pseudo</label>
              <span class="required">*</span>
              <input type="text"
                     id="username"
                     name="username"
                     v-model="account.username"
                     class="form-control"
                     required autofocus>
              <div class="help-block"
                   v-if="errors.username"
                   v-text="errors.username[0]">
              </div>
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
                   v-text="errors.email[0]">
              </div>
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
                   v-text="errors.password[0]">
              </div>
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

            <button class="btn btn-lg btn-black btn-block mt-5"
                    @click="registerAccount">
              <i class="fal fa-check mr-2"></i>
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
  import RegisterCarousel from './RegisterCarousel.vue'
  import mixins from '../../mixins'
  import { mapActions } from 'vuex'

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
      'app-register-carousel': RegisterCarousel
    },
    mixins: [mixins],
    methods: {
      ...mapActions([
        'toggleLoader'
      ]),

      /**
       * Register the account.
       */
      registerAccount() {
        this.$store.dispatch('toggleLoader')

        axios.post(route('register.store'), this.account)
          .then(() => {
            this.$store.dispatch('toggleLoader')
            this.toggleModal()
            this.account = {}
            this.$emit('accountCreated')
          })
          .catch(error => {
            this.$store.dispatch('toggleLoader')
            this.errors = error.response.data.errors
          })
      }
    },
    created() {
      if (this.invitation.data) {
        this.account.email = this.invitation.data.email
      }
    }
  }
</script>
