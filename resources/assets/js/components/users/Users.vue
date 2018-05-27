<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Utilisateurs</h1>

      <div class="header__stats">
        <span v-text="modelCount"/>
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
        .get(window.route("api.users.index"), {
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
