<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Articles</h1>

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

      <AddArticle @article:created="addArticle"/>
    </div>

    <div class="main__container main__container--grey">
      <Pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--top"
        @pagination:switched="getArticles"/>

      <template v-if="!articles.length && !fetching">
        <p class="paragraph__no-model-found">Il n'existe encore aucun article.</p>
      </template>

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
            @article:deleted="removeArticle(index)"/>
        </transition-group>
      </template>

      <Pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--bottom"
        @pagination:switched="getArticles"/>
    </div>

    <MoonLoader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import Pagination from "../pagination/Pagination";
import AppSelect from "../select/AppSelect";
import Article from "./Article.vue";
import AddArticle from "./AddArticle.vue";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";

import { eventBus } from "../../app";
import { mapGetters } from "vuex";

export default {
  components: {
    Pagination,
    AppSelect,
    Article,
    AddArticle,
    MoonLoader
  },
  data() {
    return {
      articles: [],
      meta: {},
      sort: "",
      sortOptions: [
        { label: "Aucun", value: "" },
        { label: "Référence", value: "reference" },
        { label: "Description", value: "description" },
        { label: "Type", value: "type" },
        { label: "Niveaux de gris", value: "greyscale" },
        { label: "Date de création", value: "created_at" }
      ],
      errors: {},
      fetching: false,
      modelNameSingular: "article",
      modelNamePlural: "articles",
      modelGender: "M"
    };
  },
  computed: {
    ...mapGetters(["loaderState"])
  },
  created() {
    eventBus.$on("articleWasCreated", article => {
      this.articles.unshift(article);
    });

    eventBus.$on("articleWasUpdated", data => {
      this.updateArticle(data);
    });
  },
  mounted() {
    this.getArticles();
  },
  methods: {
    getArticles(page = 1) {
      this.$store.dispatch("toggleLoader");
      this.fetching = true;
      window.axios
        .get(window.route("api.articles.index", this.sort.value), {
          params: {
            page
          }
        })
        .then(response => {
          this.articles = response.data.data;
          this.meta = response.data.meta;
          this.$store.dispatch("toggleLoader");
          this.fetching = false;
        })
        .catch(error => {
          this.errors = error.response.data;
          this.$store.dispatch("toggleLoader");
          this.fetching = false;
        });
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
      for (let article of this.articles) {
        if (data.id === article.id) {
          article.reference = data.reference;
          article.description = data.description;
          article.type = data.type;
          article.category_id = data.category_id;
        }
      }
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
