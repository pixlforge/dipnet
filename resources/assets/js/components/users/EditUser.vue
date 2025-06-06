<template>
  <div class="modal__slider">
    <form
      class="modal__container"
      @submit.prevent="updateUser">
      <h2 class="modal__title">Modifier <strong>{{ user.username }}</strong></h2>

      <!-- Username -->
      <ModalInput
        id="username"
        ref="focus"
        v-model="currentUser.username"
        type="text"
        required>
        <template slot="label">Nom d'utilisateur</template>
        <template
          v-if="errors.username"
          slot="errors">
          {{ errors.username[0] }}
        </template>
      </ModalInput>

      <!-- E-mail -->
      <ModalInput
        id="email"
        v-model="currentUser.email"
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
        v-model="currentUser.password"
        type="password">
        <template slot="label">Mot de passe</template>
        <template
          v-if="errors.password"
          slot="errors">
          {{ errors.password[0] }}
        </template>
      </ModalInput>

      <!-- Password Confirmation -->
      <ModalInput
        id="password_confirmation"
        v-model="currentUser.password_confirmation"
        type="password">
        <template slot="label">Confirmation</template>
      </ModalInput>

      <!-- Role -->
      <ModalSelect
        id="role"
        :options="optionsForRole"
        v-model="currentUser.role"
        required>
        <template slot="label">Rôle</template>
        <template
          v-if="errors.role"
          slot="errors">
          {{ errors.role[0] }}
        </template>
      </ModalSelect>

      <!-- Company -->
      <ModalSelect
        v-if="userIsNotAdmin"
        id="company_id"
        :options="optionsForCompany"
        v-model="currentUser.company_id">
        <template slot="label">Société</template>
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
          Mettre à jour
        </Button>

        <!-- Cancel -->
        <Button
          primary
          grey
          panel
          @click.prevent="$emit('edit-user:close')">
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
import { loader, modal } from "../../mixins";

export default {
  components: {
    Button,
    ModalInput,
    ModalSelect
  },
  mixins: [loader, modal],
  props: {
    user: {
      type: Object,
      required: true
    },
    companies: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      currentUser: {
        id: this.user.id,
        username: this.user.username,
        email: this.user.email,
        password: "",
        password_confirmation: "",
        role: this.user.role,
        company_id: this.user.company_id
      },
      errors: {},
      optionsForRole: [
        { label: "Utilisateur", value: "utilisateur" },
        { label: "Administrateur", value: "administrateur" }
      ],
      optionsForCompany: []
    };
  },
  computed: {
    userIsNotAdmin() {
      return (
        this.currentUser.role === "" || this.currentUser.role === "utilisateur"
      );
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
    async updateUser() {
      this.toggleLoader();
      try {
        let res = await window.axios.patch(
          window.route("admin.users.update", [this.user.id]),
          this.currentUser
        );
        this.$emit("user:updated", res.data);
        this.$emit("edit-user:close");
        this.toggleLoader();
      } catch (err) {
        this.errors = err.response.data.errors;
        this.toggleLoader();
      }
    }
  }
};
</script>
