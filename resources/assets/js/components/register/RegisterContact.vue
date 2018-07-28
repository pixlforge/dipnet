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
          v-if="registrationType === 'add'"
          class="register__summary-item">
          <span class="badge__summary">3</span>
          <span class="register__summary-label">Création de votre société</span>
        </div>

        <div class="register__summary-item">
          <span
            v-if="registrationType === 'add'"
            class="badge__summary">
            4
          </span>
          <span
            v-else
            class="badge__summary">
            3
          </span>
          <span class="register__summary-label">Terminé!</span>
        </div>
      </div>
    </section>

    <section class="register__form-section">
      <div class="register__form">
        <h1 class="register__title">Votre premier contact</h1>

        <div class="form__group">
          <label for="name">Prénom et Nom / Contact</label>
          <span class="form__required">*</span>
          <input
            id="name"
            v-model.trim="contact.name"
            type="text"
            name="name"
            class="form__input"
            required
            autofocus>
          <div
            v-if="errors.name"
            class="form__alert">
            {{ errors.name[0] }}
          </div>
        </div>

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

        <div class="form__group">
          <label for="fax">Fax</label>
          <input
            id="fax"
            v-model.trim="contact.fax"
            type="text"
            name="fax"
            class="form__input">
          <div
            v-if="errors.fax"
            class="form__alert">
            {{ errors.fax[0] }}
          </div>
        </div>

        <div class="register__buttons">
          <button
            role="button"
            class="btn btn--red"
            @click="createContact">
            <i class="fal fa-check"/>
            Créer le contact
          </button>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import { appName, logo } from "../../mixins";
import { mapActions } from "vuex";

export default {
  mixins: [appName, logo],
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
      contact: {
        name: "",
        address_line1: "",
        address_line2: "",
        zip: "",
        city: "",
        phone_number: "",
        fax: "",
        invitation_company: this.invitation.company_id
      },
      errors: {}
    };
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    async createContact() {
      this.toggleLoader();
      try {
        await window.axios.post(
          window.route("register.contact.store"),
          this.contact
        );
        this.$emit("contact:created");
        this.toggleLoader();
        this.contact = {};
      } catch (err) {
        this.errors = err.response.data.errors;
        this.toggleLoader();
      }
    }
  }
};
</script>
