<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Utilisateurs</h1>

      <!-- Count -->
      <div class="header__stats">
        <span v-text="modelCount"/>
      </div>

      <!-- Sort -->
      <div class="header__sort">
        <AppSelect
          :options="sortOptions"
          v-model="sort"
          @input="selectSort(sort)">
          <span class="dropdown__title">Trier par</span>
          <span><strong>{{ sort ? sort.label : 'Aucun' }}</strong></span>
        </AppSelect>
      </div>

      <!-- Add button -->
      <Button
        primary
        red
        long
        @click.prevent="openAddPanel">
        <i class="fal fa-plus-circle"/>
        Ajouter un utilisateur
      </Button>
    </div>

    <!-- Main content -->
    <main class="main__container">
      <section class="main__section">
        <Pagination
          v-if="meta.total > 25"
          :meta="meta"
          class="pagination pagination--top"
          @pagination:switched="getUsers"/>

        <transition-group
          name="pagination"
          tag="div"
          mode="out-in">
          <User
            v-for="(user, index) in users"
            :key="user.id"
            :user="user"
            @edit-user:open="openEditPanel"
            @user:deleted="removeUser(index)"/>
        </transition-group>

        <Pagination
          v-if="meta.total > 25"
          :meta="meta"
          class="pagination pagination--bottom"
          @pagination:switched="getUsers"/>
      </section>
    </main>

    <transition name="fade">
      <div
        v-if="showModal"
        class="modal__background"
        @click.prevent="closePanels"/>
    </transition>
    
    <transition name="slide">
      <AddUser
        v-if="showAddPanel"
        :companies="companies"
        @user:created="addUser"
        @add-user:close="closePanels"/>
    </transition>

    <transition name="slide">
      <EditUser
        v-if="showEditPanel"
        :user="modelToEdit"
        :companies="companies"
        @user:updated="updateUser"
        @edit-user:close="closePanels"/>
    </transition>

    <MoonLoader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import User from "./User.vue";
import AddUser from "./AddUser";
import EditUser from "./EditUser";
import Button from "../buttons/Button";
import AppSelect from "../select/AppSelect";
import Pagination from "../pagination/Pagination";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";

import { mapGetters, mapActions } from "vuex";
import { loader, modal, panels, modelCount } from "../../mixins";

export default {
  components: {
    User,
    AddUser,
    EditUser,
    Button,
    AppSelect,
    Pagination,
    MoonLoader
  },
  mixins: [loader, modal, panels, modelCount],
  props: {
    companies: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      users: [],
      meta: {},
      errors: {},
      sort: "",
      sortOptions: [
        { label: "Aucun", value: "" },
        { label: "Nom d'utilisateur", value: "username" },
        { label: "Email", value: "email" },
        { label: "Rôle", value: "role" },
        { label: "Date de création", value: "created_at" }
      ],
      modelNameSingular: "utilisateur",
      modelNamePlural: "utilisateurs",
      modelGender: "M"
    };
  },
  computed: {
    ...mapGetters(["loaderState"])
  },
  mounted() {
    this.getUsers();
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    async getUsers(page = 1) {
      this.toggleLoader();
      try {
        let res = await window.axios.get(
          window.route("api.users.index", this.sort.value),
          { params: { page } }
        );
        this.users = res.data.data;
        this.meta = res.data.meta;
        this.toggleLoader();
      } catch (err) {
        this.errors = err.response.data;
        this.toggleLoader();
      }
    },
    selectSort(sort) {
      this.sort = sort;
      this.getUsers();
    },
    addUser(user) {
      this.users.unshift(user);
      window.flash({
        message: "La création de l'utilisateur a réussi.",
        level: "success"
      });
    },
    updateUser(data) {
      let index = this.users.findIndex(user => user.id === data.id);
      this.users[index] = data;
      window.flash({
        message:
          "Les modifications apportées à l'utilisateur ont été enregistrées.",
        level: "success"
      });
    },
    removeUser(index) {
      this.users.splice(index, 1);
      window.flash({
        message: "Suppression de l'utilisateur réussie.",
        level: "success"
      });
    }
  }
};
</script>
