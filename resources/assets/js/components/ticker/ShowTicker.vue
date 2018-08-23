<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">{{ bodyExcerpt }}</h1>

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
    <div class="profile__container">
      <div class="profile__box">

        <div class="profile__box-item">
          <div class="profile__avatar">
            <IllustrationTicker/>
          </div>
        </div>

        <div class="profile__box-item">

          <!-- Body -->
          <div class="profile__item">
            <h3>Contenu</h3>
            <p>{{ currentTicker.body }}</p>
          </div>

          <!-- Active -->
          <div class="profile__item">
            <h3>Statut</h3>
            <p>{{ currentTicker.active ? 'Actif' : 'Inactif' }}</p>
          </div>
        </div>

        <div class="profile__box-item">

          <!-- Created at -->
          <div class="profile__item">
            <h3>Créé le</h3>
            <p>{{ getDate(ticker.created_at) }}</p>
          </div>

          <!-- Updated at -->
          <div class="profile__item">
            <h3>Dernière mise à jour</h3>
            <p>{{ getDate(currentTicker.updated_at) }}</p>
          </div>
        </div>
      </div>
    </div>

    <transition name="fade">
      <div
        v-if="showModal"
        class="modal__background"
        @click.prevent="closePanels"/>
    </transition>

    <transition name="slide">
      <EditTicker
        v-if="showEditPanel"
        :ticker="currentTicker"
        @ticker:updated="congratulations"
        @edit-ticker:close="closePanels"/>
    </transition>

    <MoonLoader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import Button from "../buttons/Button";
import EditTicker from "../ticker/EditTicker";
import MoonLoader from "vue-spinner/src/MoonLoader";
import IllustrationTicker from "../illustrations/IllustrationTicker";

import { mapGetters } from "vuex";
import { dates, filters, modal, panels, loader } from "../../mixins";

export default {
  components: {
    Button,
    EditTicker,
    MoonLoader,
    IllustrationTicker
  },
  mixins: [dates, filters, modal, panels, loader],
  props: {
    ticker: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      currentTicker: this.ticker
    };
  },
  computed: {
    ...mapGetters(["loaderState"]),
    bodyExcerpt() {
      if (this.currentTicker.body.length > 45) {
        return this.currentTicker.body.substr(0, 45) + "...";
      } else {
        return this.currentTicker.body;
      }
    }
  },
  methods: {
    congratulations(ticker) {
      this.currentTicker = ticker;
      window.flash({
        message: "Les modifications apportées au ticker ont été enregistrées.",
        level: "success"
      });
    }
  }
};
</script>

