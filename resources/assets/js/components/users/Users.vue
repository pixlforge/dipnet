<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Utilisateurs</h1>

      <div class="header__stats">
        <span v-text="modelCount"/>
      </div>

      <div>
        <AppSelect
          :options="sortOptions"
          v-model="sort"
          @input="selectSort(sort)">
          <span class="dropdown__title">Trier par</span>
          <span><strong>{{ sort ? sort.label : 'Aucun' }}</strong></span>
        </AppSelect>
      </div>

      <add-user
        :companies="companies"
        @userWasCreated="addUser"/>
    </div>

    <div class="main__container main__container--grey">
      <pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--top"
        @paginationSwitched="getUsers"/>

      <transition-group
        name="pagination"
        tag="div"
        mode="out-in">
        <user
          v-for="(user, index) in users"
          :key="user.id"
          :user="user"
          :companies="companies"
          class="card__container"
          @userWasDeleted="removeUser(index)"/>
      </transition-group>

      <pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--bottom"
        @paginationSwitched="getUsers"/>
    </div>

    <moon-loader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import Pagination from "../pagination/Pagination";
import AppSelect from "../select/AppSelect";
import AddUser from "./AddUser";
import User from "./User.vue";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import mixins from "../../mixins";
import { eventBus } from "../../app";
import { mapGetters } from "vuex";

export default {
  components: {
    User,
    AddUser,
    Pagination,
    AppSelect,
    MoonLoader
  },
  mixins: [mixins],
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
  created() {
    eventBus.$on("userWasUpdated", data => {
      this.updateUser(data);
    });
  },
  mounted() {
    this.getUsers();
  },
  methods: {
    getUsers(page = 1) {
      this.$store.dispatch("toggleLoader");
      window.axios
        .get(window.route("api.users.index", this.sort.value), {
          params: {
            page
          }
        })
        .then(response => {
          this.users = response.data.data;
          this.meta = response.data.meta;
          this.$store.dispatch("toggleLoader");
        });
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
      for (let user of this.users) {
        if (data.id === user.id) {
          user.username = data.username;
          user.email = data.email;
          user.role = data.role;
        }
      }
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
