<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Articles</h1>
      <div class="header__stats">
        {{ meta.total }}
        {{ meta.total == 0 || meta.total == 1 ? 'article' : 'articles' }}
      </div>
      <app-add-article @articleWasCreated="addArticle">
      </app-add-article>
    </div>

    <div class="main__container main__container--grey">
      <app-pagination class="pagination pagination--top"
                      v-if="articles.length"
                      :data-meta="meta"
                      @paginationSwitched="getArticles">
      </app-pagination>

      <template v-if="!articles.length && !fetching">
        <p class="paragraph__no-model-found">Il n'existe encore aucun article.</p>
      </template>

      <template v-else>
        <transition-group name="pagination" tag="div" mode="out-in">
          <app-article class="card__container"
                       v-for="(article, index) in articles"
                       :key="article.id"
                       :data-article="article"
                       @articleWasDeleted="removeArticle(index)">
          </app-article>
        </transition-group>
      </template>

      <app-pagination class="pagination pagination--bottom"
                      v-if="articles.length"
                      :data-meta="meta"
                      @paginationSwitched="getArticles">
      </app-pagination>
    </div>

    <app-moon-loader :loading="loaderState"
                     :color="loader.color"
                     :size="loader.size">
    </app-moon-loader>
  </div>
</template>

<script>
  import Pagination from '../pagination/Pagination'
  import Article from './Article.vue'
  import AddArticle from './AddArticle.vue'
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import mixins from '../../mixins'
  import { eventBus } from '../../app'
  import { mapGetters } from 'vuex'

  export default {
    props: ['data-categories'],
    data() {
      return {
        articles: [],
        categories: this.dataCategories,
        meta: {},
        errors: {},
        fetching: false
      }
    },
    mixins: [mixins],
    components: {
      'app-article': Article,
      'app-add-article': AddArticle,
      'app-pagination': Pagination,
      'app-moon-loader': MoonLoader
    },
    computed: {
      ...mapGetters([
        'loaderState'
      ])
    },
    methods: {
      /**
       * Fetch the articles paginated data.
       */
      getArticles(page = 1) {
        this.$store.dispatch('toggleLoader')
        this.fetching = true

        axios.get(route('api.articles.index'), {
          params: {
            page
          }
        }).then(response => {
          this.articles = response.data.data
          this.meta = response.data.meta
          this.$store.dispatch('toggleLoader')
          this.fetching = false
        }).catch(error => {
          this.errors = error.response.data
          this.$store.dispatch('toggleLoader')
          this.fetching = false
        })
      },

      /**
       * Add a new article to the list.
       */
      addArticle(article) {
        this.articles.unshift(article)
        flash({
          message: 'La création de l\'article a réussi.',
          level: 'success'
        })
      },

      /**
       * Update the article details.
       */
      updateArticle(data) {
        for (let article of this.articles) {
          if (data.id === article.id) {
            article.reference = data.reference
            article.description = data.description
            article.type = data.type
            article.category_id = data.category_id
          }
        }
        flash({
          message: 'Les modifications apportées à l\'article ont été enregistrées.',
          level: 'success'
        })
      },

      /**
       * Remove an article from the list.
       */
      removeArticle(index) {
        this.articles.splice(index, 1)
        flash({
          message: 'Suppression de l\'article réussie.',
          level: 'success'
        })
      }
    },
    created() {
      eventBus.$on('articleWasUpdated', (data) => {
        this.updateArticle(data)
      })
    },
    mounted() {
      this.getArticles()
    }
  }
</script>
