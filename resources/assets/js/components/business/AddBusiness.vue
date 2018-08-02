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

      <!-- User -->
      <ModalSelect
        v-if="userIsAdmin"
        id="user_id"
        :options="optionsForUser"
        v-model="business.user_id">
        <template slot="label">Utilisateur</template>
        <template
          v-if="errors.user_id"
          slot="errors">
          {{ errors.user_id[0] }}
        </template>
      </ModalSelect>

      <!-- Company -->
      <ModalSelect
        v-if="userIsAdmin"
        id="company_id"
        :options="optionsForCompany"
        v-model="business.company_id">
        <template slot="label">Société</template>
        <template
          v-if="errors.company_id"
          slot="errors">
          {{ errors.company_id[0] }}
        </template>
      </ModalSelect>

      <!-- Contact -->
      <ModalSelect
        id="contact_id"
        :options="optionsForContact"
        v-model="business.contact_id">
        <template slot="label">Contact</template>
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
          @click.prevent="$emit('add-business:close')">
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

export default {
  components: {
    ModalInput,
    ModalSelect
  },
  props: {
    companies: {
      type: Array,
      required: true
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
      required: true
    }
  },
  data() {
    return {
      business: {
        name: "",
        description: "",
        user_id: "",
        company_id: "",
        contact_id: "",
        folder_color: ""
      },
      errors: {},
      optionsForUser: [],
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
      if (this.filteredContacts) {
        return this.filteredContacts.map(contact => {
          return { label: contact.name, value: contact.id };
        });
      }
    },
    filteredContacts() {
      if (this.userIsAdmin) {
        if (this.business.company_id !== "") {
          return this.contacts.filter(contact => {
            return contact.company_id === this.business.company_id;
          });
        }
      } else {
        return this.contacts;
      }
    },
    userIsAdmin() {
      return this.user.role === "administrateur";
    }
  },
  mounted() {
    this.$refs.focus.$el.children[2].focus();

    this.optionsForUser = this.users.map(user => {
      return { label: user.username, value: user.id };
    });

    this.optionsForCompany = this.companies.map(company => {
      return { label: company.name, value: company.id };
    });
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    async addBusiness() {
      this.toggleLoader();
      if (!this.userIsAdmin) {
        this.business.company_id = this.user.company.id;
      }
      try {
        let res = await window.axios.post(
          window.route("admin.businesses.store"),
          this.business
        );
        this.$emit("business:created", res.data);
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
