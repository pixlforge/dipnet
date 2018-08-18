<template>
  <div class="register__container">
    <section class="register__first-section">
      <div class="login__logo login__logo--color">
        <img
          :src="logoColor"
          :alt="`${appName} logo`">
      </div>
      <div class="register__form register__form--center">
        <h1 class="register__title">Rejoindre ma société</h1>

        <p class="register__lead">
          Demandez une invitation à l'un de vos collègues membres déjà inscrit, afin de pouvoir créer votre compte en
          tant que membre de votre société.
        </p>

        <!-- Back to menu -->
        <button
          role="button"
          class="button__primary button__primary--orange"
          @click.prevent="$emit('back-to:menu')">
          <i class="fal fa-arrow-left"/>
          Retour au menu
        </button>
      </div>
    </section>

    <section class="login__second-section">
      <div class="login__logo login__logo--bw">
        <img
          :src="logoBw"
          :alt="`${appName} logo`">
      </div>
      <Carousel/>
    </section>
  </div>
</template>

<script>
import Carousel from "../carousel/Carousel";

import { appName, logo } from "../../mixins";

export default {
  components: {
    Carousel
  },
  mixins: [appName, logo]
};
</script>
