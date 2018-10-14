<template>
  <div class="modal__slider">
    <form
      class="modal__container"
      @submit.prevent="updateContact">
      <h2 class="modal__title">Modifier le contact <strong>{{ contact.name }}</strong></h2>

      <!-- Company -->
      <ModalSelect
        v-if="userIsAdmin"
        id="company_id"
        :options="optionsForCompany"
        v-model="currentContact.company_id">
        <template slot="label">Société</template>
        <template
          v-if="errors.company_id"
          slot="errors">
          {{ errors.company_id[0] }}
        </template>
      </ModalSelect>

      <!-- Name -->
      <ModalInput
        id="name"
        ref="focus"
        v-model="currentContact.name"
        type="text"
        required>
        <template slot="label">Nom / Prénom</template>
        <template
          v-if="errors.description"
          slot="errors">
          {{ errors.description[0] }}
        </template>
      </ModalInput>

      <!-- Address line 1 -->
      <ModalInput
        id="address_line1"
        v-model="currentContact.address_line1"
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
        v-model="currentContact.address_line2"
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
        v-model="currentContact.zip"
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
        v-model="currentContact.city"
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
        v-model="currentContact.phone_number"
        type="text">
        <template slot="label">Téléphone</template>
        <template
          v-if="errors.phone_number"
          slot="errors">
          {{ errors.phone_number[0] }}
        </template>
      </ModalInput>

      <!-- Email -->
      <ModalInput
        id="email"
        v-model="currentContact.email"
        type="email">
        <template slot="label">E-mail</template>
        <template
          v-if="errors.email"
          slot="errors">
          {{ errors.email[0] }}
        </template>
      </ModalInput>

      <!-- Controls -->
      <div class="modal__buttons">

        <!-- Submit -->
        <Button
          type="submit"
          primary
          red
          panel>
          <i class="fal fa-check"/>
          Mettre à jour
        </Button>

        <!-- Cancel -->
        <Button
          primary
          grey
          panel
          @click.prevent="$emit('edit-contact:close')">
          <i class="fal fa-times"/>
          Annuler
        </Button>
      </div>
    </form>
  </div>
</template>

<script>
import Button from "../buttons/Button";
import ModalInput from "../forms/ModalInput";
import ModalSelect from "../forms/ModalSelect";

import { mapActions } from "vuex";

export default {
  components: {
    Button,
    ModalInput,
    ModalSelect
  },
  props: {
    contact: {
      type: Object,
      required: true
    },
    companies: {
      type: Array,
      required: false,
      default() {
        return [];
      }
    },
    user: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      currentContact: {
        id: this.contact.id,
        name: this.contact.name,
        address_line1: this.contact.address_line1,
        address_line2: this.contact.address_line2,
        zip: this.contact.zip,
        city: this.contact.city,
        phone_number: this.contact.phone_number,
        fax: this.contact.fax,
        email: this.contact.email,
        company_id: this.contact.company_id
      },
      errors: {},
      optionsForCompany: []
    };
  },
  computed: {
    userIsAdmin() {
      return this.user.role === "administrateur";
    },
    endpoint() {
      return this.userIsAdmin ? "admin.contacts.update" : "contacts.update";
    }
  },
  mounted() {
    this.$refs.focus.$el.children[2].focus();

    this.optionsForCompany = this.companies.map(company => {
      return { label: company.name, value: company.id };
    });
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    async updateContact() {
      this.toggleLoader();
      try {
        let res = await window.axios.patch(
          window.route(this.endpoint, [this.contact.id]),
          this.currentContact
        );
        this.$emit("contact:updated", res.data);
        this.$emit("edit-contact:close");
        this.toggleLoader();
      } catch (err) {
        this.errors = err.response.data.errors;
        this.toggleLoader();
      }
    }
  }
};
</script>
