<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-10 my-5 mx-auto">
        <div class="row">
          <div
            class="col-12 d-flex flex-column flex-lg-row justify-content-between align-items-center center-on-small-only">
            <h1 class="mt-5">Articles</h1>
            <div class="mt-5">
              {{ articles.length }}
              {{ articles.length == 0 || articles.length == 1 ? 'article' : 'articles' }}
            </div>

            <!--Add Article-->
            <app-add-article :data-categories="categories"
                             @articleWasCreated="addArticle">
            </app-add-article>
          </div>
        </div>
      </div>
    </div>
    <div class="row bg-grey-light">
      <div class="col-10 mx-auto my-7">

        <!--Article-->
        <transition-group name="highlight">
          <app-article class="card card-custom center-on-small-only"
                       v-for="(article, index) in articles"
                       :data-article="article"
                       :data-categories="categories"
                       :key="article.id"
                       @articleWasDeleted="removeArticle(index)">
          </app-article>
        </transition-group>

      </div>
    </div>

    <!--Loader-->
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
