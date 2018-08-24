<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">{{ currentFormat.name }}</h1>

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
              <IllustrationFormat/>
            </div>
          </div>

          <div class="profile__box-item">

            <!-- Name -->
            <div class="profile__item">
              <h3>Nom</h3>
              <p>{{ currentFormat.name }}</p>
            </div>

            <!-- Height -->
            <div class="profile__item">
              <h3>Hauteur</h3>
              <p>{{ currentFormat.height }}</p>
            </div>

            <!-- Width -->
            <div class="profile__item">
              <h3>Largeur</h3>
              <p>{{ currentFormat.width }}</p>
            </div>
          </div>

          <div class="profile__box-item">

            <!-- Created at -->
            <div class="profile__item">
              <h3>Créé le</h3>
              <p>{{ getDate(format.created_at) }}</p>
            </div>

            <!-- Updated at -->
            <div class="profile__item">
              <h3>Dernière mise à jour</h3>
              <p>{{ getDate(currentFormat.updated_at) }}</p>
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
      <EditFormat
        v-if="showEditPanel"
        :format="currentFormat"
        @format:updated="congratulations"
        @edit-format:close="closePanels"/>
    </transition>

    <MoonLoader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import Button from "../buttons/Button";
import EditFormat from "../format/EditFormat";
import MoonLoader from "vue-spinner/src/MoonLoader";
import IllustrationFormat from "../illustrations/IllustrationFormat";

import { mapGetters } from "vuex";
import { dates, filters, modal, panels, loader } from "../../mixins";

export default {
  components: {
    Button,
    EditFormat,
    MoonLoader,
    IllustrationFormat
  },
  mixins: [dates, filters, modal, panels, loader],
  props: {
    format: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      currentFormat: this.format
    };
  },
  computed: {
    ...mapGetters(["loaderState"])
  },
  methods: {
    congratulations(format) {
      this.currentFormat = format;
      window.flash({
        message: "Les modifications apportées au format ont été enregistrées.",
        level: "success"
      });
    }
  }
};
</script>

