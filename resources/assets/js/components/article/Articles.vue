<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Articles</h1>

      <!-- Count -->
      <div class="header__stats">
        <span v-text="modelCount"/>
      </div>

      <!-- Sort -->
      <AppSelect
        :options="sortOptions"
        v-model="sort"
        @input="selectSort(sort)">
        <span class="dropdown__title">Trier par</span>
        <span><strong>{{ sort ? sort.label : 'Aucun' }}</strong></span>
      </AppSelect>

      <!-- Add button -->
      <Button
        primary
        red
        long
        @click.prevent="openAddPanel">
        <i class="fal fa-plus-circle"/>
        Ajouter un article
      </Button>
    </div>

    <div class="main__container main__container--grey">
      <Pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--top"
        @pagination:switched="getArticles"/>

      <div
        v-if="!articles.length && !fetching"
        class="main__no-results">
        <p>Il n'existe encore aucun article.</p>
        <IllustrationNoData/>
      </div>

      <template v-else>
        <transition-group
          name="pagination"
          tag="div"
          mode="out-in">
          <Article
            v-for="(article, index) in articles"
            :key="article.id"
            :article="article"
            class="card__container"
            @edit-article:open="openEditPanel"
            @article:deleted="removeArticle(index)"/>
        </transition-group>
      </template>

      <Pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--bottom"
        @pagination:switched="getArticles"/>
    </div>

    <transition name="fade">
      <div
        v-if="showModal"
        class="modal__background"
        @click.prevent="closePanels"/>
    </transition>

    <transition name="slide">
      <AddArticle
        v-if="showAddPanel"
        @article:created="addArticle"
        @add-article:close="closePanels"/>
    </transition>

    <transition name="slide">
      <EditArticle
        v-if="showEditPanel"
        :article="modelToEdit"
        @article:updated="updateArticle"
        @edit-article:close="closePanels"/>
    </transition>

    <MoonLoader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import Article from "./Article.vue";
import Button from "../buttons/Button";
import AddArticle from "./AddArticle.vue";
import EditArticle from "./EditArticle.vue";
import AppSelect from "../select/AppSelect";
import Pagination from "../pagination/Pagination";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import IllustrationNoData from "../illustrations/IllustrationNoData";

import { mapGetters, mapActions } from "vuex";
import { loader, modal, panels, modelCount } from "../../mixins";

export default {
  components: {
    Article,
    Button,
    AddArticle,
    EditArticle,
    AppSelect,
    Pagination,
    MoonLoader,
    IllustrationNoData
  },
  mixins: [loader, modal, panels, modelCount],
  data() {
    return {
      articles: [],
      meta: {},
      errors: {},
      sort: "",
      sortOptions: [
        { label: "Aucun", value: "" },
        { label: "Référence", value: "reference" },
        { label: "Description", value: "description" },
        { label: "Type", value: "type" },
        { label: "Niveaux de gris", value: "greyscale" },
        { label: "Date de création", value: "created_at" }
      ],
      fetching: false,
      modelNameSingular: "article",
      modelNamePlural: "articles",
      modelGender: "M"
    };
  },
  computed: {
    ...mapGetters(["loaderState"])
  },
  mounted() {
    this.getArticles();
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    async getArticles(page = 1) {
      this.toggleLoader();
      this.fetching = true;
      try {
        let res = await window.axios.get(
          window.route("api.articles.index", this.sort.value),
          { params: { page } }
        );
        this.articles = res.data.data;
        this.meta = res.data.meta;
        this.fetching = false;
        this.toggleLoader();
      } catch (err) {
        this.errors = err.response.data;
        this.fetching = false;
        this.toggleLoader();
      }
    },
    selectSort(sort) {
      this.sort = sort;
      this.getArticles();
    },
    addArticle(article) {
      this.articles.unshift(article);
      window.flash({
        message: "La création de l'article a réussi.",
        level: "success"
      });
    },
    updateArticle(data) {
      let index = this.articles.findIndex(article => article.id === data.id);
      this.articles[index] = data;
      window.flash({
        message:
          "Les modifications apportées à l'article ont été enregistrées.",
        level: "success"
      });
    },
    removeArticle(index) {
      this.articles.splice(index, 1);
      window.flash({
        message: "Suppression de l'article réussie.",
        level: "success"
      });
    }
  }
};
</script>
