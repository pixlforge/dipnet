<template>
  <div class="register__container">
    <section class="register__first-section">
      <div
        class="login__logo login__logo--color"
        aria-hidden="true">
        <img
          :src="logoColor"
          :alt="`${appName} logo`">
      </div>
      <form
        class="register__form"
        @submit.prevent="registerAccount">
        <h1 class="register__title">Création du compte</h1>

        <!-- Username -->
        <ModalInput
          id="username"
          ref="focus"
          v-model="account.username"
          type="text"
          required>
          <template slot="label">Nom d'utilisateur</template>
          <template
            v-if="errors.username"
            slot="errors">
            {{ errors.username[0] }}
          </template>
        </ModalInput>

        <!-- Email -->
        <ModalInput
          id="email"
          v-model="account.email"
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
          v-model="account.password"
          type="password"
          required>
          <template slot="label">Mot de passe</template>
          <template
            v-if="errors.password"
            slot="errors">
            {{ errors.password[0] }}
          </template>
        </ModalInput>

        <!-- Password confirmation -->
        <ModalInput
          id="password_confirmation"
          v-model="account.password_confirmation"
          type="password"
          required>
          <template slot="label">Confirmation</template>
          <template
            v-if="errors.password_confirmation"
            slot="errors">
            {{ errors.password_confirmation[0] }}
          </template>
        </ModalInput>

        <div class="register__buttons">
          <Button
            type="submit"
            primary
            red
            long>
            <i class="fal fa-check"/>
            Créer le compte
          </Button>
        </div>

        <div class="register__login">
          Vous disposez déjà d'un compte?
          <a
            :href="loginRoute"
            class="register__link">
            Connectez-vous
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
  </div>
</template>

<script>
import Button from "../buttons/Button";
import Carousel from "../carousel/Carousel";
import ModalInput from "../forms/ModalInput";

import { mapActions } from "vuex";
import { appName, logo, registration } from "../../mixins";

export default {
  components: {
    Button,
    Carousel,
    ModalInput
  },
  mixins: [appName, logo, registration],
  props: {
    registrationType: {
      type: String,
      required: true
    },
    invitation: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      account: {
        username: "",
        email: "",
        password: "",
        password_confirmation: "",
        is_solo: this.registrationType === "self" ? true : false
      },
      errors: {}
    };
  },
  mounted() {
    this.$refs.focus.$el.children[2].focus();
  },
  created() {
    if (this.invitation) {
      this.account.email = this.invitation.email;
    }
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    async registerAccount() {
      this.toggleLoader();
      try {
        await window.axios.post(window.route("register.store"), this.account);
        this.toggleLoader();
        this.$emit("account:created");
        this.account = {};
      } catch (err) {
        this.errors = err.response.data.errors;
        this.toggleLoader();
      }
    }
  }
};
</script>
