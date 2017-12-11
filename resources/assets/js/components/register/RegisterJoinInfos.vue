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

          <p class="info">
            Demandez une invitation à l'un de vos collègues membres de {{ appName }}
            afin de pouvoir créer votre compte en tant que membre de votre société.
          </p>

          <p class="text-center">
            <span @click="backToMenu"><i class="fal fa-arrow-left fa-2x back-arrow"></i></span>
          </p>

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
  import mixins from '../../mixins'

  export default {
    components: {
      'app-register-carousel': RegisterCarousel,
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
