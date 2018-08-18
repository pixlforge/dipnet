<template>
  <div class="register__container">
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
      <form
        class="register__form"
        @submit.prevent="createContact">
        <h1 class="register__title">Votre premier <strong>contact</strong></h1>

        <!-- Username -->
        <ModalInput
          id="username"
          ref="focus"
          v-model="contact.name"
          type="text"
          required>
          <template slot="label">Prénom et Nom / Contact</template>
          <template
            v-if="errors.name"
            slot="errors">
            {{ errors.name[0] }}
          </template>
        </ModalInput>

        <!-- Address line 1 -->
        <ModalInput
          id="address_line1"
          v-model="contact.address_line1"
          type="text"
          required>
          <template slot="label">Adresse ligne 1</template>
          <template
            v-if="errors.address_line1"
            slot="errors">
            {{ errors.address_line1[0] }}
          </template>
        </ModalInput>

        <!-- Address line 2 -->
        <ModalInput
          id="address_line2"
          v-model="contact.address_line2"
          type="text">
          <template slot="label">Adresse ligne 2</template>
          <template
            v-if="errors.address_line2"
            slot="errors">
            {{ errors.address_line2[0] }}
          </template>
        </ModalInput>

        <!-- Zip -->
        <ModalInput
          id="zip"
          v-model="contact.zip"
          type="text"
          required>
          <template slot="label">NPA</template>
          <template
            v-if="errors.zip"
            slot="errors">
            {{ errors.zip[0] }}
          </template>
        </ModalInput>

        <!-- City -->
        <ModalInput
          id="city"
          v-model="contact.city"
          type="text"
          required>
          <template slot="label">Localité</template>
          <template
            v-if="errors.city"
            slot="errors">
            {{ errors.city[0] }}
          </template>
        </ModalInput>

        <!-- Phone number -->
        <ModalInput
          id="phone_number"
          v-model="contact.phone_number"
          type="text">
          <template slot="label">Téléphone</template>
          <template
            v-if="errors.phone_number"
            slot="errors">
            {{ errors.phone_number[0] }}
          </template>
        </ModalInput>

        <!-- Fax -->
        <ModalInput
          id="fax"
          v-model="contact.fax"
          type="text">
          <template slot="label">Fax</template>
          <template
            v-if="errors.fax"
            slot="errors">
            {{ errors.fax[0] }}
          </template>
        </ModalInput>

        <div class="register__buttons">
          <Button
            type="submit"
            primary
            red
            long>
            <i class="fal fa-check"/>
            Créer le contact
          </Button>
        </div>
      </form>
    </section>
  </div>
</template>

<script>
import Button from "../buttons/Button";
import ModalInput from "../forms/ModalInput";

import { mapActions } from "vuex";
import { appName, logo } from "../../mixins";

export default {
  components: {
    Button,
    ModalInput
  },
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
  mounted() {
    this.$refs.focus.$el.children[2].focus();
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
