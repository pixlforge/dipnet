<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Articles</h1>
      <div class="header__stats">
        {{ articles.length }}
        {{ articles.length == 0 || articles.length == 1 ? 'article' : 'articles' }}
      </div>
      <app-add-article @articleWasCreated="addArticle">
      </app-add-article>
    </div>

    <div class="main__container main__container--grey">
      <transition-group name="highlight" tag="div">
        <app-article class="card__container"
                     v-for="(article, index) in articles"
                     :data-article="article"
                     :key="index"
                     @articleWasDeleted="removeArticle(index)">
        </app-article>
      </transition-group>
    </div>

    <app-moon-loader :loading="loaderState"
                     :color="loader.color"
                     :size="loader.size">
    </app-moon-loader>
  </div>
</template>

<script>
  import Article from './Article.vue'
  import AddArticle from './AddArticle.vue'
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import mixins from '../../mixins'
  import { eventBus } from '../../app'
  import { mapGetters } from 'vuex'

  export default {
    props: [
      'data-articles',
      'data-categories'
    ],
    data() {
      return {
        articles: this.dataArticles,
        categories: this.dataCategories
      }
    },
    mixins: [mixins],
    components: {
      'app-article': Article,
      'app-add-article': AddArticle,
      'app-moon-loader': MoonLoader
    },
    computed: {
      ...mapGetters([
        'loaderState'
      ])
    },
    methods: {
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
    }
  }
</script>
