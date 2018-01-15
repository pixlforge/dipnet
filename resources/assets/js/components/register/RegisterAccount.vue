<template>
  <div class="register__container"
       @keyup.enter="registerAccount">
    <section class="register__first-section">
      <div class="login__logo login__logo--color"
           aria-hidden="true">
        <img :src="logoColor" :alt="`${appName} logo`">
      </div>
      <div class="register__form">
        <h1 class="register__title">Création du compte</h1>

        <div class="form__group">
          <label for="username">Nom d'utilisateur</label>
          <span class="form__required">*</span>
          <input type="text"
                 name="username"
                 id="username"
                 class="form__input"
                 v-model.trim="account.username"
                 required autofocus>
          <div class="form__alert"
               v-if="errors.username">
            {{ errors.username[0] }}
          </div>
        </div>

        <div class="form__group">
          <label for="email">Email</label>
          <span class="form__required">*</span>
          <input type="email"
                 name="email"
                 id="email"
                 class="form__input"
                 v-model.trim="account.email"
                 required>
          <div class="form__alert"
               v-if="errors.email">
            {{ errors.email[0] }}
          </div>
        </div>

        <div class="form__group">
          <label for="password">Mot de passe</label>
          <span class="form__required">*</span>
          <input type="password"
                 name="password"
                 id="password"
                 class="form__input"
                 v-model.trim="account.password"
                 required>
          <div class="form__alert"
               v-if="errors.password">
            {{ errors.password[0] }}
          </div>
        </div>

        <div class="form__group">
          <label for="password_confirmation">Mot de passe</label>
          <span class="form__required">*</span>
          <input type="password"
                 name="password_confirmation"
                 id="password_confirmation"
                 class="form__input"
                 v-model.trim="account.password_confirmation"
                 required>
          <div class="form__alert"
               v-if="errors.password_confirmation">
            {{ errors.password_confirmation[0] }}
          </div>
        </div>

        <div class="register__buttons">
          <button class="btn btn--black"
                  @click="registerAccount">
            <i class="fal fa-check"></i>
            Créer le compte
          </button>
        </div>

        <div class="register__login">
          Vous disposez déjà d'un compte?
          <a :href="loginRoute" class="register__link">
            Connectez-vous
          </a>
        </div>
      </div>
    </section>

    <section class="login__second-section">
      <div class="login__logo login__logo--bw"
           aria-hidden="true">
        <img :src="logoBw" :alt="`${appName} logo`">
      </div>
      <app-carousel></app-carousel>
    </section>
  </div>
</template>

<script>
  import Carousel from '../carousel/Carousel'
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
      'app-carousel': Carousel
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
