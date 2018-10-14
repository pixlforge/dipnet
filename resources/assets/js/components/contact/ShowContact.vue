<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">{{ currentContact.name }}</h1>

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
    
    <!-- Main content -->
    <main class="main__container">
      <section class="main__section main__section--white">
        <div class="profile__box">

          <div class="profile__box-item">
            <div class="profile__avatar">
              <IllustrationAddress/>
            </div>
          </div>

          <div class="profile__box-item">

            <!-- Address line 1 -->
            <div class="profile__item">
              <h3>Adresse ligne 1</h3>
              <p>{{ currentContact.address_line1 }}</p>
            </div>

            <!-- Address line 2 -->
            <div class="profile__item">
              <h3>Adresse ligne 2</h3>
              <p>{{ currentContact.address_line2 ? currentContact.address_line2 : 'Aucune' }}</p>
            </div>

            <!-- Zip & City -->
            <div class="profile__item">
              <h3>Localité</h3>
              <p>{{ currentContact.zip }} {{ currentContact.city | capitalize }}</p>
            </div>

            <!-- Phone number -->
            <div class="profile__item">
              <h3>Téléphone</h3>
              <p>{{ currentContact.phone_number ? currentContact.phone_number : 'Aucun' }}</p>
            </div>

            <!-- Email -->
            <div class="profile__item">
              <h3>Adresse e-mail</h3>
              <p>{{ currentContact.email ? currentContact.email : 'Aucune' }}</p>
            </div>
          </div>

          <div class="profile__box-item">

            <!-- User -->
            <div class="profile__item">
              <h3>Créé par</h3>
              <p>{{ contact.user ? contact.user.username : 'Admin' }}</p>
            </div>

            <!-- Created at -->
            <div class="profile__item">
              <h3>Créé le</h3>
              <p>{{ getDate(contact.created_at) }}</p>
            </div>

            <!-- Updated at -->
            <div class="profile__item">
              <h3>Dernière mise à jour</h3>
              <p>{{ getDate(currentContact.updated_at) }}</p>
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
      <EditContact
        v-if="showEditPanel"
        :contact="currentContact"
        :companies="companies"
        :user="user"
        @contact:updated="congratulations"
        @edit-contact:close="closePanels"/>
    </transition>

    <MoonLoader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import Button from "../buttons/Button";
import EditContact from "../contact/EditContact";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import IllustrationAddress from "../illustrations/IllustrationAddress";

import { mapGetters } from "vuex";
import { dates, filters, modal, panels, loader } from "../../mixins";

export default {
  components: {
    Button,
    EditContact,
    MoonLoader,
    IllustrationAddress
  },
  mixins: [dates, filters, modal, panels, loader],
  props: {
    contact: {
      type: Object,
      required: true
    },
    user: {
      type: Object,
      required: true
    },
    companies: {
      type: Array,
      required: false,
      default() {
        return [];
      }
    }
  },
  data() {
    return {
      currentContact: this.contact
    };
  },
  computed: {
    ...mapGetters(["loaderState"])
  },
  methods: {
    congratulations(contact) {
      this.currentContact = contact;
      window.flash({
        message: "Les modifications apportées au contact ont été enregistrées.",
        level: "success"
      });
    }
  }
};
</script>

