<template>
  <div class="register__container">
    <section class="register__first-section">
      <div class="login__logo login__logo--color"
           aria-hidden="true">
        <img :src="logoColor" :alt="`${appName} logo`">
      </div>
      <div class="register__form">
        <h1 class="register__title">Création de compte</h1>
        <button class="register__btn register__btn--red"
                role="button"
                @click="addCompany">
          Je désire enregistrer ma société
        </button>
        <button class="register__btn register__btn--orange"
                role="button"
                @click="joinCompany">
          Je désire rejoindre ma société
        </button>
        <button class="register__btn register__btn--purple"
                role="button"
                @click="asSelf">
          Je désire commander à mon nom
        </button>
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
      <carousel></carousel>
    </section>
  </div>
</template>

<script>
  import Carousel from '../carousel/Carousel'
  import mixins from '../../mixins'
  import { mapGetters, mapActions } from 'vuex'

  export default {
    components: {
      Carousel
    },
    mixins: [mixins],
    methods: {
      joinCompany() {
        this.$emit('registrationSelection', 'join')
      },
      addCompany() {
        this.$emit('registrationSelection', 'add')
      },
      asSelf() {
        this.$emit('registrationSelection', 'self')
      }
    }
  }
</script>
