<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">{{ currentUser.username }}</h1>

      <!-- Edit -->
      <Button
        primary
        red
        long
        title="Modifier"
        @click.prevent="openEditPanel">
        <i class="fal fa-edit"/>
        Modifier
      </Button>
    </div>

    <main class="main__container">
      <section class="main__section main__section--white">
        <div class="profile__box">
          <div class="profile__box-item">
            <div class="profile__avatar">
              <template v-if="user.avatar">
                <img
                  :src="`/storage/avatar${user.avatar.path}`"
                  alt="Avatar de l'utilisateur">
              </template>
              <template v-else>
                <img
                  :src="`/img/placeholders/${randomAvatar}`"
                  alt="Avatar de l'utilisateur">
              </template>
            </div>
          </div>

          <div class="profile__box-item">

            <!-- Username -->
            <div class="profile__item">
              <h3>Nom d'utilisateur</h3>
              <p>{{ currentUser.username }}</p>
            </div>

            <!-- Email -->
            <div class="profile__item">
              <h3>Adresse e-mail</h3>
              <p>{{ currentUser.email }}</p>
            </div>

            <!-- Role -->
            <div class="profile__item">
              <h3>Rôle</h3>
              <p>{{ currentUser.role | capitalize }}</p>
            </div>

            <!-- Account type -->
            <div class="profile__item">
              <h3>Compte</h3>
              <p>{{ accountType }}</p>
            </div>
          </div>

          <div class="profile__box-item">

            <!-- Created at -->
            <div class="profile__item">
              <h3>Créé le</h3>
              <p>{{ getDate(user.created_at) }}</p>
            </div>

            <!-- Updated at -->
            <div class="profile__item">
              <h3>Dernière mise à jour</h3>
              <p>{{ getDate(currentUser.updated_at) }}</p>
            </div>
          </div>
        </div>
      </section>
    </main>

    <transition name="fade">
      <div
        v-if="showModal"
        class="modal__background"
        @click.prevent="closePanels"/>
    </transition>

    <transition name="slide">
      <EditUser
        v-if="showEditPanel"
        :user="user"
        :companies="companies"
        @user:updated="congratulations"
        @edit-user:close="closePanels"/>
    </transition>

    <MoonLoader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import Button from "../buttons/Button";
import EditUser from "../users/EditUser";
import MoonLoader from "vue-spinner/src/MoonLoader";

import { mapGetters } from "vuex";
import { dates, filters, modal, panels, loader } from "../../mixins";

export default {
  components: {
    Button,
    EditUser,
    MoonLoader
  },
  mixins: [dates, filters, modal, panels, loader],
  props: {
    user: {
      type: Object,
      required: true
    },
    companies: {
      type: Array,
      required: true
    },
    randomAvatar: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      currentUser: this.user
    };
  },
  computed: {
    ...mapGetters(["loaderState"]),
    accountType() {
      if (this.currentUser.role === "administrateur") {
        return "Administrateur";
      } else {
        if (this.currentUser.is_solo) {
          return "Particulier";
        } else {
          return `Membre de la société ${this.currentUser.company.name}`;
        }
      }
    }
  },
  methods: {
    congratulations(user) {
      this.currentUser = user;
      window.flash({
        message:
          "Les modifications apportées à l'utilisateur ont été enregistrées.",
        level: "success"
      });
    }
  }
};
</script>

