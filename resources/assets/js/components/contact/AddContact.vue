<template>
  <div class="modal__slider">
    <form
      class="modal__container"
      @submit.prevent="addContact">
      <h2 class="modal__title">Ajouter un <strong>contact</strong></h2>

      <!-- Name -->
      <ModalInput
        id="name"
        ref="focus"
        v-model="contact.name"
        type="text"
        required>
        <template slot="label">Nom</template>
        <template
          v-if="errors.description"
          slot="errors">
          {{ errors.description[0] }}
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

      <!-- Email -->
      <ModalInput
        id="email"
        v-model="contact.email"
        type="email"
        required>
        <template slot="label">E-mail</template>
        <template
          v-if="errors.email"
          slot="errors">
          {{ errors.email[0] }}
        </template>
      </ModalInput>

      <!-- Company -->
      <ModalSelect
        v-if="userIsAdmin"
        id="company_id"
        :options="optionsForCompany"
        v-model="contact.company_id">
        <template slot="label">Société</template>
        <template
          v-if="errors.company_id"
          slot="errors">
          {{ errors.company_id[0] }}
        </template>
      </ModalSelect>

      <!-- Controls -->
      <div class="modal__buttons">
        <button
          type="submit"
          role="button"
          class="btn btn--red">
          <i class="fal fa-check"/>
          Ajouter
        </button>
        <button
          role="button"
          class="btn btn--grey"
          @click.prevent="$emit('add-contact:close')">
          <i class="fal fa-times"/>
          Annuler
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import ModalInput from "../forms/ModalInput";
import ModalSelect from "../forms/ModalSelect";

import { mapActions } from "vuex";
import { eventBus } from "../../app";

export default {
  components: {
    ModalInput,
    ModalSelect
  },
  props: {
    companies: {
      type: Array,
      required: false,
      default: () => {
        return [];
      }
    },
    user: {
      type: Object,
      required: false,
      default: () => {
        return [];
      }
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
        email: "",
        company_id: null
      },
      errors: {},
      optionsForCompany: []
    };
  },
  computed: {
    userIsAdmin() {
      return this.user.role === "administrateur";
    }
  },
  mounted() {
    this.$refs.focus.$el.children[2].focus();

    this.optionsForCompany = this.companies.map(company => {
      return { label: company.name, value: company.id };
    });
  },
  created() {
    eventBus.$on("dropdown:add-contact", () => this.toggleModal());
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    async addContact() {
      this.toggleLoader();
      try {
        let res = await window.axios.post(
          window.route("contacts.store"),
          this.contact
        );
        this.contact = res.data;
        this.$emit("contact:created", this.contact);
        this.$emit("add-contact:close");
        this.toggleLoader();
      } catch (err) {
        this.errors = err.response.data.errors;
        this.toggleLoader();
      }
    }
  }
};
</script>
