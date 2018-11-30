<template>
  <div class="modal__slider">
    <form
      class="modal__container"
      @submit.prevent="addBusiness">
      <h2 class="modal__title">Ajouter une <strong>affaire</strong></h2>

      <!-- Name -->
      <ModalInput
        id="name"
        ref="focus"
        v-model="business.name"
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
        v-model="business.description"
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
        v-model="business.company_id"
        @input="business.user_id = ''">
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
        v-model="business.user_id"
        @input="business.company_id = ''">
        <template slot="label">Utilisateur</template>
        <template
          v-if="errors.user_id"
          slot="errors">
          {{ errors.user_id[0] }}
        </template>
      </ModalSelect>

      <!-- Default billing contact -->
      <ModalSelect
        v-if="!user.is_solo"
        id="contact_id"
        :options="optionsForContact"
        v-model="business.contact_id">
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
        v-model="business.folder_color">
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
          Ajouter
        </Button>

        <!-- Cancel -->
        <Button
          primary
          grey
          panel
          @click.prevent="$emit('add-business:close')">
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
      default() {
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
      business: {
        name: "",
        description: "",
        company_id: "",
        user_id: "",
        contact_id: "",
        folder_color: ""
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
        if (this.business.company_id === "") {
          contacts = this.contacts.filter(contact => {
            return contact.user_id == this.business.user_id;
          });
        }

        if (this.business.user_id === "") {
          contacts = this.contacts.filter(contact => {
            return contact.company_id == this.business.company_id;
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
        return "admin.businesses.store";
      } else {
        return "businesses.store";
      }
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
    async addBusiness() {
      this.toggleLoader();
      if (!this.userIsAdmin) {
        this.business.company_id = this.user.company.id;
      }
      try {
        let res = await window.axios.post(
          window.route(this.endpoint),
          this.business
        );
        this.$emit("business:created", res.data);
        eventBus.$emit("business:created", res.data);
        this.$emit("add-business:close");
        this.toggleLoader();
      } catch (err) {
        this.errors = err.response.data.errors;
        this.toggleLoader();
      }
    }
  }
};
</script>
