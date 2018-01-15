<template>
  <div class="register__container">
    <section class="register__first-section">
      <div class="login__logo login__logo--color">
        <img :src="logoColor" :alt="`${dataAppName} logo`">
      </div>
      <div class="register__form">
        <h1 class="register__title">Rejoindre ma société</h1>

        <p class="register__lead">
          Demandez une invitation à l'un de vos collègues membres de {{ appName }} afin de pouvoir créer votre compte en
          tant que membre de votre société.
        </p>

        <div class="register__back" @click="backToMenu">
          <i class="fal fa-arrow-left fa-2x"></i>
        </div>
      </div>
    </section>

    <section class="login__second-section">
      <div class="login__logo login__logo--bw">
        <img :src="logoBw" :alt="`${dataAppName} logo`">
      </div>
      <app-carousel></app-carousel>
    </section>
  </div>
</template>

<script>
  import Carousel from '../carousel/Carousel'
  import mixins from '../../mixins'

  export default {
    components: {
      'app-carousel': Carousel
    },
    mixins: [mixins],
    methods: {
      /**
       * Send the user back to the menu.
       */
      backToMenu() {
        this.$emit('backToMenu')
      }
    }
  }
</script>
