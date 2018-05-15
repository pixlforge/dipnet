<template>
  <div>
    <div class="card__img">
      <img src="/img/placeholders/contact-bullet.jpg"
           alt="Bullet point image">
    </div>

    <div class="card__title">
      {{ dataArticle.reference }}
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Description</span>
        {{ dataArticle.description | capitalize }}
      </div>
      <div>
        <span class="card__label">Type</span>
        {{ dataArticle.type | capitalize }}
      </div>
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Créé</span>
        {{ getDate(dataArticle.created_at) }}
      </div>
      <div>
        <span class="card__label">Modifié</span>
        {{ getDate(dataArticle.updated_at) }}
      </div>
    </div>

    <div class="card__controls">
      <div title="Supprimer"
           @click="destroy">
        <i class="fal fa-times"></i>
      </div>
      <div title="Modifier">
        <edit-article :data-article="dataArticle"></edit-article>
      </div>
    </div>
  </div>
</template>

<script>
  import EditArticle from './EditArticle.vue'
  import moment from 'moment'
  import mixins from '../../mixins'

  export default {
    components: {
      EditArticle
    },
    props: {
      dataArticle: {
        type: Object,
        required: true
      }
    },
    mixins: [mixins],
    methods: {
      /**
       * Delete the article.
       */
      destroy() {
        axios.delete(route('articles.destroy', [this.dataArticle.id]))
        this.$emit('articleWasDeleted', this.dataArticle.id)
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
