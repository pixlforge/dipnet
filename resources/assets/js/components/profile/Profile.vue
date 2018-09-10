<template>
  <div>
    <div class="header__container">
      <div class="profile__header">
        <h1 class="header__title">{{ user.username }}</h1>
        <div
          v-if="user.email_confirmed"
          class="profile__icon profile__icon--success">
          <i class="fal fa-check-circle"/>
        </div>
        <div
          v-else
          class="profile__icon profile__icon--warning">
          <i class="fal fa-times-circle"/>
        </div>
      </div>

      <div class="profile__header profile__header--second">
        <p
          v-if="!user.email_confirmed"
          class="profile__header-item">
          Compte non vérifié
        </p>

        <SendConfirmationEmailAgain
          v-if="!user.email_confirmed"
          class="profile__header-item"/>

        <!-- Edit account -->
        <Button
          primary
          red
          long
          @click.prevent="openEditPanel">
          <i class="fal fa-edit"/>
          Éditer mon compte
        </Button>
      </div>
    </div>

    <!-- Main content -->
    <main class="main__container">
      <section class="main__section main__section--white">
        <div class="profile__box">

          <div class="profile__box-item">
            <div class="profile__avatar">
              <img
                v-if="avatar"
                :src="avatar"
                alt="Avatar">
              <img
                v-else
                :src="randomAvatarPath"
                alt="Avatar">
            </div>
          </div>

          <div class="profile__box-item">
            <div class="profile__item">
              <h3>Adresse e-mail</h3>
              <p>{{ user.email }}</p>
            </div>
            <div class="profile__item">
              <h3>Création du compte</h3>
              <p>{{ getDate(user.created_at) }}</p>
            </div>
          </div>

          <div
            v-if="userIsNotAdmin"
            class="profile__box-item">
            <div class="profile__item">
              <h3>Membre de</h3>
              <p>{{ user.company.name }}</p>
            </div>
            <div class="profile__item">
              <h3>Réalisation de</h3>
              <span v-if="orders == 0">Aucune commande</span>
              <span v-if="orders == 1">{{ orders }} commande</span>
              <span v-if="orders > 1"> {{ orders }} commandes</span>
            </div>
            <div class="profile__item">
              <h3>Participe à</h3>
              <span v-if="businesses == 0">Aucune affaire</span>
              <span v-if="businesses == 1">{{ businesses }} affaire</span>
              <span v-if="businesses > 1"> {{ businesses }} affaires</span>
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
      <UpdateProfile
        v-if="showEditPanel"
        :user="user"
        :avatar="avatar"
        :random-avatar="randomAvatar"
        @profile:updated="profileUpdated"
        @update-profile:close="closePanels"/>
    </transition>

    <MoonLoader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import Button from "../buttons/Button";
import UpdateProfile from "./UpdateProfile.vue";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import SendConfirmationEmailAgain from "../register/SendConfirmationEmailAgain.vue";

import { mapGetters } from "vuex";
import { dates, loader, modal, panels } from "../../mixins";

export default {
  components: {
    Button,
    SendConfirmationEmailAgain,
    UpdateProfile,
    MoonLoader
  },
  mixins: [dates, loader, modal, panels],
  props: {
    user: {
      type: Object,
      required: true
    },
    orders: {
      type: Number,
      required: true
    },
    businesses: {
      type: Number,
      required: true
    },
    avatar: {
      type: String,
      required: true
    },
    randomAvatar: {
      type: String,
      required: true
    }
  },
  computed: {
    ...mapGetters(["loaderState"]),
    randomAvatarPath() {
      return "img/placeholders/" + this.randomAvatar;
    },
    userIsNotAdmin() {
      return this.user.role !== "administrateur";
    }
  },
  methods: {
    profileUpdated(emailUpdated) {
      if (emailUpdated) {
        window.flash({
          message:
            "Votre compte a été mis à jour avec succès! Veuillez re-confirmer votre compte, s'il-vous-plaît.",
          level: "success"
        });
      } else {
        window.flash({
          message: "Votre compte a été mis à jour avec succès!",
          level: "success"
        });
      }
      setTimeout(() => {
        window.location = window.route("profile.index");
      }, 1500);
    }
  }
};
</script>
