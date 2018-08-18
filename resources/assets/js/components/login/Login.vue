<template>
  <div class="login__container">
    <section class="login__first-section">
      <div
        class="login__logo login__logo--color"
        aria-hidden="true">
        <img
          :src="logoColor"
          :alt="`${appName} logo`">
      </div>
      <form
        class="login__form"
        @submit.prevent="login">
        <h1 class="login__title">Connexion</h1>

        <!-- Email -->
        <ModalInput
          id="email"
          ref="focus"
          v-model="email"
          type="email"
          required>
          <template slot="label">Adresse E-mail</template>
          <template
            v-if="errors.email"
            slot="errors">
            {{ errors.email[0] }}
          </template>
        </ModalInput>

        <!-- Password -->
        <ModalInput
          id="password"
          v-model="password"
          type="password"
          required>
          <template slot="label">Mot de passe</template>
          <template
            v-if="errors.password"
            slot="errors">
            {{ errors.password[0] }}
          </template>
        </ModalInput>

        <!-- Remember -->
        <ModalCheckbox
          id="remember"
          v-model="remember">
          <template slot="label">Se rappeler de moi</template>
          <template
            v-if="errors.remember"
            slot="errors">
            {{ errors.remember[0] }}
          </template>
        </ModalCheckbox>

        <div class="login__buttons">
          <button
            type="submit"
            role="button"
            class="button__primary button__primary--red btn__primary--long">
            <i class="fal fa-key"/>
            Connexion
          </button>
        </div>

        <div class="login__forgotten">
          <a
            :href="forgottenRoute"
            class="login__link">
            Mot de passe oublié?
          </a>
        </div>
        <div class="login__register">
          Pas encore enregistré?
          <a
            :href="registerRoute"
            class="login__link">
            Enregistrez-vous
          </a>
        </div>
      </form>
    </section>

    <section class="login__second-section">
      <div
        class="login__logo login__logo--bw"
        aria-hidden="true">
        <img
          :src="logoBw"
          :alt="`${appName} logo`">
      </div>
      <Carousel/>
    </section>

    <MoonLoader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import ModalInput from "../forms/ModalInput";
import Carousel from "../carousel/Carousel.vue";
import ModalCheckbox from "../forms/ModalCheckbox";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";

import { mapGetters, mapActions } from "vuex";
import { logo, appName, registration, loader } from "../../mixins";

export default {
  components: {
    ModalInput,
    Carousel,
    ModalCheckbox,
    MoonLoader
  },
  mixins: [logo, appName, registration, loader],
  data() {
    return {
      email: "",
      password: "",
      remember: true,
      errors: {}
    };
  },
  computed: {
    ...mapGetters(["loaderState"])
  },
  mounted() {
    this.$refs.focus.$el.children[2].focus();
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    async login() {
      this.toggleLoader();
      try {
        await window.axios.post(window.route("login"), {
          email: this.email,
          password: this.password
        });
        window.flash({
          message: "Bienvenue!",
          level: "success"
        });
        setTimeout(() => {
          window.location = window.route("index");
        }, 1000);
      } catch (err) {
        this.errors = err.response.data.errors;
        this.toggleLoader();
      }
    }
  }
};
</script>