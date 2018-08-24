<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">{{ currentArticle.description }}</h1>

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
              <IllustrationArticle/>
            </div>
          </div>

          <div class="profile__box-item">

            <!-- Description -->
            <div class="profile__item">
              <h3>Description</h3>
              <p>{{ currentArticle.description }}</p>
            </div>

            <!-- Reference -->
            <div class="profile__item">
              <h3>Référence</h3>
              <p>{{ currentArticle.reference }}</p>
            </div>

            <!-- Type -->
            <div class="profile__item">
              <h3>Type</h3>
              <p>{{ currentArticle.type | capitalize }}</p>
            </div>

            <!-- Greyscale -->
            <div
              v-if="currentArticle.type === 'impression'"
              class="profile__item">
              <h3>Mode</h3>
              <p>{{ currentArticle.greyscale ? 'Noir & blanc' : 'Couleur' }}</p>
            </div>
          </div>

          <div class="profile__box-item">

            <!-- Created at -->
            <div class="profile__item">
              <h3>Créé le</h3>
              <p>{{ getDate(article.created_at) }}</p>
            </div>

            <!-- Updated at -->
            <div class="profile__item">
              <h3>Dernière mise à jour</h3>
              <p>{{ getDate(currentArticle.updated_at) }}</p>
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
      <EditArticle
        v-if="showEditPanel"
        :article="currentArticle"
        @article:updated="congratulations"
        @edit-article:close="closePanels"/>
    </transition>

    <MoonLoader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import Button from "../buttons/Button";
import EditArticle from "../article/EditArticle";
import MoonLoader from "vue-spinner/src/MoonLoader";
import IllustrationArticle from "../illustrations/IllustrationArticle";

import { mapGetters } from "vuex";
import { dates, filters, modal, panels, loader } from "../../mixins";

export default {
  components: {
    Button,
    EditArticle,
    MoonLoader,
    IllustrationArticle
  },
  mixins: [dates, filters, modal, panels, loader],
  props: {
    article: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      currentArticle: this.article
    };
  },
  computed: {
    ...mapGetters(["loaderState"])
  },
  methods: {
    congratulations(article) {
      this.currentArticle = article;
      window.flash({
        message:
          "Les modifications apportées à l'article ont été enregistrées.",
        level: "success"
      });
    }
  }
};
</script>

