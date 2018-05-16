<template>
  <div class="login__container" @keyup.enter="login">
    <section class="login__first-section">
      <div class="login__logo login__logo--color"
           aria-hidden="true">
        <img :src="logoColor" :alt="`${appName} logo`">
      </div>
      <div class="login__form">
        <h1 class="login__title">Connexion</h1>

        <div class="form__group">
          <label for="email">Email</label>
          <span class="form__required">*</span>
          <input type="text"
                 name="email"
                 id="email"
                 class="form__input"
                 v-model.trim="email"
                 required autofocus>
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
                 v-model.trim="password"
                 required>
          <div class="form__alert"
               v-if="errors.password">
            {{ errors.password[0] }}
          </div>
        </div>

        <label for="remember">
          <input type="checkbox"
                 name="remember"
                 id="remember"
                 :checked="remember">
          Se rappeler
        </label>

        <div class="login__buttons">
          <button class="btn btn--red"
                  role="button"
                  @click="login">
            <i class="fal fa-key"></i>
            Connexion
          </button>
        </div>

        <div class="login__forgotten">
          <a :href="forgottenRoute" class="login__link">
            Mot de passe oublié?
          </a>
        </div>
        <div class="login__register">
          Pas encore enregistré?
          <a :href="registerRoute" class="login__link">
            Enregistrez-vous
          </a>
        </div>
      </div>
    </section>

    <section class="login__second-section">
      <div class="login__logo login__logo--bw"
           aria-hidden="true">
        <img :src="logoBw" :alt="`${appName} logo`">
      </div>
      <carousel></carousel>
    </section>

    <moon-loader :loading="loaderState"
                 :color="loader.color"
                 :size="loader.size"></moon-loader>
  </div>
</template>

<script>
  import Carousel from '../carousel/Carousel.vue'
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import mixins from '../../mixins'
  import { mapGetters, mapActions } from 'vuex'

  export default {
    components: {
      Carousel,
      MoonLoader
    },
    data() {
      return {
        email: '',
        password: '',
        remember: true,
        errors: {}
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
      login() {
        this.$store.dispatch('toggleLoader')
        axios.post(route('login'), {
          email: this.email,
          password: this.password
        }).then(() => {
          flash({
            message: "Bienvenue!",
            level: 'success'
          })
          setTimeout(() => {
            window.location = route('index')
          }, 1000)
        }).catch(error => {
          this.$store.dispatch('toggleLoader')
          this.errors = error.response.data.errors
        })
      }
    }
  }
</script>