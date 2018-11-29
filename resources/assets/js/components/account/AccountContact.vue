<template>
  <div
    class="register__container"
    @keyup.enter="createContact">
    <section class="register__summary-section">
      <div
        class="register__logo register__logo--summary"
        aria-hidden="true">
        <img
          :src="logoBw"
          :alt="`${appName} logo`">
      </div>
      <div class="register__summary">
        <div class="register__summary-item register__summary-item--done">
          <span class="badge__summary"><i class="fa fa-check"/></span>
          <span class="register__summary-label">Création de votre compte</span>
        </div>

        <div class="register__summary-item register__summary-item--active">
          <span class="badge__summary">2</span>
          <span class="register__summary-label">Création de votre premier contact</span>
        </div>

        <div
          v-if="shouldDisplayCompanyChecklistItem"
          class="register__summary-item">
          <span class="badge__summary">3</span>
          <span class="register__summary-label">Création de votre société</span>
        </div>

        <div class="register__summary-item">
          <span
            v-if="shouldDisplayCompanyChecklistItem"
            class="badge__summary">4</span>
          <span
            v-else
            class="badge__summary">3</span>
          <span class="register__summary-label">Terminé!</span>
        </div>
      </div>
    </section>

    <section class="register__form-section">
      <div class="register__form register__form--details">
        <h1 class="register__title">Votre premier contact</h1>

        <!-- First Name -->
        <ModalInput
          id="first_name"
          ref="focus"
          v-model="contact.first_name"
          type="text"
          required>
          <template slot="label">Prénom</template>
          <template
            v-if="errors.first_name"
            slot="errors">
            {{ errors.first_name[0] }}
          </template>
        </ModalInput>

        <!-- Last Name -->
        <ModalInput
          id="last_name"
          v-model="contact.last_name"
          type="text"
          required>
          <template slot="label">Nom</template>
          <template
            v-if="errors.last_name"
            slot="errors">
            {{ errors.last_name[0] }}
          </template>
        </ModalInput>

        <!-- Company Name -->
        <ModalInput
          id="company_name"
          v-model="contact.company_name"
          type="text">
          <template slot="label">Nom de la société</template>
          <template
            v-if="errors.company_name"
            slot="errors">
            {{ errors.company_name[0] }}
          </template>
        </ModalInput>

        <div class="form__group">
          <label for="address_line1">Adresse ligne 1</label>
          <span class="form__required">*</span>
          <input
            id="address_line1"
            v-model.trim="contact.address_line1"
            type="text"
            name="address_line1"
            class="form__input"
            required>
          <div
            v-if="errors.address_line1"
            class="form__alert">
            {{ errors.address_line1[0] }}
          </div>
        </div>

        <div class="form__group">
          <label for="address_line2">Adresse ligne 2</label>
          <input
            id="address_line2"
            v-model.trim="contact.address_line2"
            type="text"
            name="address_line2"
            class="form__input">
          <div
            v-if="errors.address_line2"
            class="form__alert">
            {{ errors.address_line2[0] }}
          </div>
        </div>

        <div class="form__group">
          <label for="zip">NPA</label>
          <span class="form__required">*</span>
          <input
            id="zip"
            v-model.trim="contact.zip"
            type="text"
            name="zip"
            class="form__input"
            required>
          <div
            v-if="errors.zip"
            class="form__alert">
            {{ errors.zip[0] }}
          </div>
        </div>

        <div class="form__group">
          <label for="city">Localité</label>
          <span class="form__required">*</span>
          <input
            id="city"
            v-model.trim="contact.city"
            type="text"
            name="city"
            class="form__input"
            required>
          <div
            v-if="errors.city"
            class="form__alert">
            {{ errors.city[0] }}
          </div>
        </div>

        <div class="form__group">
          <label for="phone_number">Téléphone</label>
          <input
            id="phone_number"
            v-model.trim="contact.phone_number"
            type="text"
            name="phone_number"
            class="form__input">
          <div
            v-if="errors.phone_number"
            class="form__alert">
            {{ errors.phone_number[0] }}
          </div>
        </div>

        <div class="register__buttons">
          <button
            role="button"
            class="button__primary button__primary--red button__primary--long"
            @click.prevent="createContact">
            <i class="fal fa-check"/>
            Créer le contact
          </button>
        </div>
      </div>
    </section>

    <MoonLoader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import ModalInput from "../forms/ModalInput";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";

import { mapGetters, mapActions } from "vuex";
import { appName, logo, loader } from "../../mixins";

export default {
  components: {
    ModalInput,
    MoonLoader
  },
  mixins: [appName, logo, loader],
  props: {
    user: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      contact: {
        name: "",
        address_line1: "",
        address_line2: "",
        zip: "",
        city: "",
        phone_number: "",
        fax: ""
      },
      errors: {}
    };
  },
  computed: {
    ...mapGetters(["loaderState"]),
    shouldDisplayCompanyChecklistItem() {
      return !this.user.is_solo && !this.user.company_confirmed;
    }
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    createContact() {
      this.toggleLoader();
      window.axios
        .post(window.route("register.contact.store"), this.contact)
        .then(() => {
          this.contact = {};
          window.flash({
            message: "Félicitations! Votre compte a bien été mis à jour!",
            level: "success"
          });
          setTimeout(() => {
            window.location = window.route("index");
          }, 1000);
        })
        .catch(error => {
          this.errors = error.response.data.errors;
          this.toggleLoader();
        });
    }
  }
};
</script>
