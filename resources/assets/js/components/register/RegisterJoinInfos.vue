<template>
  <div class="register__container">
    <section class="register__first-section">
      <div class="login__logo login__logo--color">
        <img :src="logoColor" :alt="`${appName} logo`">
      </div>
      <div class="register__form">
        <h1 class="register__title">Rejoindre ma société</h1>

        <p class="register__lead">
          Demandez une invitation à l'un de vos collègues membres déjà inscrit, afin de pouvoir créer votre compte en
          tant que membre de votre société.
        </p>

        <div class="register__back" @click="backToMenu">
          <i class="fal fa-arrow-left fa-2x"></i>
        </div>
      </div>
    </section>

    <section class="login__second-section">
      <div class="login__logo login__logo--bw">
        <img :src="logoBw" :alt="`${appName} logo`">
      </div>
      <carousel></carousel>
    </section>
  </div>
</template>

<script>
  import Carousel from '../carousel/Carousel'
  import mixins from '../../mixins'

  export default {
    components: {
      Carousel
    },
    mixins: [mixins],
    methods: {
      backToMenu() {
        this.$emit('backToMenu')
      }
    }
  }
</script>
