<template>
  <div class="modal__slider">
    <form
      class="modal__container"
      @submit.prevent="updateBusiness">
      <h2 class="modal__title">Modifier l'affaire <strong>{{ business.name }}</strong></h2>

      <!-- Name -->
      <ModalInput
        id="name"
        ref="focus"
        v-model="currentBusiness.name"
        type="text"
        required>
        <template slot="label">Nom</template>
        <template
          v-if="errors.name"
          slot="errors">
          {{ errors.name[0] }}
        </template>
      </ModalInput>

      <!-- Description -->
      <ModalInput
        id="description"
        v-model="currentBusiness.description"
        type="text">
        <template slot="label">Description</template>
        <template
          v-if="errors.description"
          slot="errors">
          {{ errors.description[0] }}
        </template>
      </ModalInput>

      <!-- Company -->
      <ModalSelect
        v-if="userIsAdmin"
        id="company_id"
        :options="optionsForCompany"
        v-model="currentBusiness.company_id"
        @input="currentBusiness.user_id = ''">
        <template slot="label">Société</template>
        <template
          v-if="errors.company_id"
          slot="errors">
          {{ errors.company_id[0] }}
        </template>
      </ModalSelect>

      <!-- User -->
      <ModalSelect
        v-if="userIsAdmin"
        id="user_id"
        :options="optionsForUser"
        v-model="currentBusiness.user_id"
        @input="currentBusiness.company_id = ''">
        <template slot="label">Utilisateur</template>
        <template
          v-if="errors.user_id"
          slot="errors">
          {{ errors.user_id[0] }}
        </template>
      </ModalSelect>

      <!-- Default billing contact -->
      <ModalSelect
        id="contact_id"
        :options="optionsForContact"
        v-model="currentBusiness.contact_id">
        <template slot="label">Contact de facturation par défaut</template>
        <template
          v-if="errors.contact_id"
          slot="errors">
          {{ errors.contact_id[0] }}
        </template>
      </ModalSelect>

      <!-- Folder color -->
      <ModalSelect
        id="folder_color"
        :options="optionsForFolderColor"
        v-model="currentBusiness.folder_color">
        <template slot="label">Couleur</template>
        <template
          v-if="errors.folder_color"
          slot="errors">
          {{ errors.folder_color[0] }}
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
          Mettre à jour
        </Button>

        <!-- Cancel -->
        <Button
          primary
          grey
          panel
          @click.prevent="$emit('edit-business:close')">
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
    business: {
      type: Object,
      required: true
    },
    companies: {
      type: Array,
      required: false,
      default: () => {
        return [];
      }
    },
    contacts: {
      type: Array,
      required: true
    },
    user: {
      type: Object,
      required: true
    },
    users: {
      type: Array,
      required: false,
      default() {
        return [];
      }
    }
  },
  data() {
    return {
      currentBusiness: {
        id: this.business.id,
        name: this.business.name,
        description: this.business.description,
        company_id: this.business.company_id,
        user_id: this.business.user_id,
        contact_id: this.business.contact_id,
        folder_color: this.business.folder_color
      },
      errors: {},
      optionsForCompany: [],
      optionsForFolderColor: [
        { label: "Rouge", value: "red" },
        { label: "Orange", value: "orange" },
        { label: "Violet", value: "purple" },
        { label: "Bleu", value: "blue" }
      ]
    };
  },
  computed: {
    optionsForContact() {
      let contacts;

      if (this.user.role === "administrateur") {
        if (
          this.currentBusiness.company_id === "" ||
          this.currentBusiness.company_id === null
        ) {
          contacts = this.contacts.filter(contact => {
            return contact.user_id == this.currentBusiness.user_id;
          });
        }

        if (
          this.currentBusiness.user_id === "" ||
          this.currentBusiness.user_id === null
        ) {
          contacts = this.contacts.filter(contact => {
            return contact.company_id == this.currentBusiness.company_id;
          });
        }
      } else {
        contacts = this.contacts;
      }

      return contacts.map(contact => {
        return {
          label: this.contactName(contact),
          value: contact.id
        };
      });
    },
    optionsForUser() {
      return this.users
        .filter(user => {
          return user.is_solo;
        })
        .map(user => {
          return { label: user.username, value: user.id };
        });
    },
    userIsAdmin() {
      return this.user.role === "administrateur";
    },
    endpoint() {
      if (this.userIsAdmin) {
        return "admin.businesses.update";
      } else {
        return "businesses.update";
      }
    }
  },
  watch: {
    "currentBusiness.company_id"() {
      this.currentBusiness.contact_id = "";
    },
    "currentBusiness.user_id"() {
      this.currentBusiness.contact_id = "";
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
    contactName(contact) {
      let fullName = contact.first_name;
      if (contact.last_name) {
        fullName += ` ${contact.last_name}`;
      }
      if (contact.company_name) {
        fullName += ` (${contact.company_name})`;
      }
      return fullName;
    },
    async updateBusiness() {
      this.toggleLoader();
      try {
        let res = await window.axios.patch(
          window.route(this.endpoint, [this.business.reference]),
          this.currentBusiness
        );
        this.$emit("business:updated", res.data);
        this.$emit("edit-business:close");
        this.toggleLoader();
      } catch (err) {
        this.errors = err.response.data.errors;
        this.toggleLoader();
      }
    }
  }
};
</script>
