<template>
  <div class="modal__slider">
    <form
      class="modal__container"
      @submit.prevent="addContact">
      <h2 class="modal__title">Ajouter un <strong>contact</strong></h2>

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

      <!-- Email -->
      <ModalInput
        id="email"
        v-model="contact.email"
        type="email">
        <template slot="label">E-mail</template>
        <template
          v-if="errors.email"
          slot="errors">
          {{ errors.email[0] }}
        </template>
      </ModalInput>

      <!-- Company associated -->
      <ModalSelect
        v-if="userIsAdmin"
        id="company_id"
        :options="optionsForCompany"
        v-model="contact.company_id"
        required>
        <template slot="label">Société associée</template>
        <template
          v-if="errors.company_id"
          slot="errors">
          {{ errors.company_id[0] }}
        </template>
      </ModalSelect>

      <!-- Controls -->
      <div class="modal__buttons">

        <!-- Submit -->
        <Button
          type="submit"
          primary
          red
          panel>
          <i class="fal fa-check"/>
          Ajouter
        </Button>

        <!-- Cancel -->
        <Button
          primary
          grey
          panel
          @click.prevent="$emit('add-contact:close')">
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
import { eventBus } from "../../app";

export default {
  components: {
    Button,
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
        return {};
      }
    },
    component: {
      type: Object,
      required: false,
      default() {
        return {};
      }
    }
  },
  data() {
    return {
      contact: {
        first_name: "",
        last_name: "",
        company_name: "",
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
    },
    endpoint() {
      return this.userIsAdmin ? "admin.contacts.store" : "contacts.store";
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
    async addContact() {
      this.toggleLoader();
      try {
        let res = await window.axios.post(
          window.route(this.endpoint),
          this.contact
        );
        this.contact = res.data;
        this.$emit("contact:created", this.contact);
        eventBus.$emit("contact:created", {
          contact: this.contact,
          component: this.component.component,
          id: this.component.id
        });
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
