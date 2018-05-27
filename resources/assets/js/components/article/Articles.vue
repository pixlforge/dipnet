<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Articles</h1>

      <div class="header__stats">
        <span v-text="modelCount"/>
      </div>

      <add-article @articleWasCreated="addArticle"/>
    </div>

    <div class="main__container main__container--grey">
      <pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--top"
        @paginationSwitched="getArticles"/>

      <template v-if="!articles.length && !fetching">
        <p class="paragraph__no-model-found">Il n'existe encore aucun article.</p>
      </template>

      <template v-else>
        <transition-group
          name="pagination"
          tag="div"
          mode="out-in">
          <app-article
            v-for="(article, index) in articles"
            :key="article.id"
            :article="article"
            class="card__container"
            @articleWasDeleted="removeArticle(index)"/>
        </transition-group>
      </template>

      <pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--bottom"
        @paginationSwitched="getArticles"/>
    </div>

    <moon-loader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import Pagination from "../pagination/Pagination";
import Article from "./Article.vue";
import AddArticle from "./AddArticle.vue";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import mixins from "../../mixins";
import { eventBus } from "../../app";
import { mapGetters } from "vuex";

export default {
  components: {
    "app-article": Article,
    AddArticle,
    Pagination,
    MoonLoader
  },
  mixins: [mixins],
  data() {
    return {
      articles: [],
      meta: {},
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
    eventBus.$on("articleWasUpdated", data => {
      this.updateArticle(data);
    });
  },
  mounted() {
    this.getArticles();
  },
  methods: {
    /**
     * Fetch the articles paginated data.
     */
    getArticles(page = 1) {
      this.$store.dispatch("toggleLoader");
      this.fetching = true;
      window.axios
        .get(window.route("api.articles.index"), {
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
    /**
     * Add a new article to the list.
     */
    addArticle(article) {
      this.articles.unshift(article);
      window.flash({
        message: "La création de l'article a réussi.",
        level: "success"
      });
    },
    /**
     * Update the article details.
     */
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
    /**
     * Remove an article from the list.
     */
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
