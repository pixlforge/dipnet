<template>
  <div>
    <div class="card__img">
      <img src="/img/placeholders/contact-bullet.jpg"
           alt="Bullet point image">
    </div>

    <div class="card__title">
      {{ article.reference }}
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Description</span>
        {{ article.description | capitalize }}
      </div>
      <div>
        <span class="card__label">Type</span>
        {{ article.type | capitalize }}
      </div>
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Créé</span>
        {{ getDate(article.created_at) }}
      </div>
      <div>
        <span class="card__label">Modifié</span>
        {{ getDate(article.updated_at) }}
      </div>
    </div>

    <div class="card__controls">
      <div title="Supprimer"
           @click="destroy">
        <i class="fal fa-times"></i>
      </div>
      <div title="Modifier">
        <app-edit-article :data-article="article">
        </app-edit-article>
      </div>
    </div>
  </div>
</template>

<script>
  import EditArticle from './EditArticle.vue'
  import moment from 'moment'
  import mixins from '../../mixins'

  export default {
    props: [
      'data-article',
      'data-categories'
    ],
    data() {
      return {
        article: this.dataArticle,
        categories: this.dataCategories
      }
    },
    mixins: [mixins],
    components: {
      'app-edit-article': EditArticle
    },
    methods: {

      /**
       * Delete the article.
       */
      destroy() {
        axios.delete(route('articles.destroy', [this.article.id]))
        this.$emit('articleWasDeleted', this.article.id)
      },

      /**
       * Get the formatted dates.
       */
      getDate(date) {
        return moment(date).locale(this.momentLocale).format(this.momentFormat)
      }
    }
  }
</script>
