<template>
  <div
    class="modal__slider"
    @keyup.enter="addUser">

    <form
      class="modal__container"
      @submit.prevent>
      <h2 class="modal__title">Nouvel utilisateur</h2>

      <!-- Username -->
      <ModalInput
        id="username"
        ref="focus"
        v-model="user.username"
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
        v-model="user.email"
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
        v-model="user.password"
        type="password"
        required>
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
        v-model="user.password_confirmation"
        type="password"
        required>
        <template slot="label">Confirmation</template>
      </ModalInput>

      <!-- Role -->
      <ModalSelect
        id="role"
        :options="optionsForRole"
        v-model="user.role"
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
        v-model="user.company_id">
        <template slot="label">Société</template>
        <template
          v-if="errors.company_id"
          slot="errors">
          {{ errors.company_id[0] }}
        </template>
      </ModalSelect>

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
          @click.prevent="$emit('add-user:close')">
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
    }
  },
  data() {
    return {
      user: {
        username: "",
        password: "",
        password_confirmation: "",
        role: "",
        email: "",
        company_id: ""
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
      return this.user.role === "" || this.user.role === "utilisateur";
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
    async addUser() {
      if (this.user.role === "administrateur") {
        this.user.company_id = null;
      }
      this.toggleLoader();
      try {
        let res = await window.axios.post(
          window.route("admin.users.store"),
          this.user
        );
        this.user = res.data;
        this.$emit("user:created", this.user);
        this.$emit("add-user:close");
        this.toggleLoader();
      } catch (err) {
        this.errors = err.response.data.errors;
        this.toggleLoader();
      }
    }
  }
};
</script>