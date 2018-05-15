<template>
  <div>
    <div class="card__img">
      <img src="/img/placeholders/contact-bullet.jpg"
           alt="Bullet point image">
    </div>

    <div class="card__title">
      {{ document.filename }}
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Type</span>
        {{ document.mime_type }}
      </div>
      <div>
        <span class="card__label">Taille</span>
        {{ document.size }}
      </div>
    </div>

    <div class="card__meta">
      <div v-if="document.article">
        <span class="card__label">Impression</span>
        {{ document.article.description }}
      </div>
      <div>
        <span class="card__label">Quantité</span>
        {{ document.quantity }}
      </div>
      <div>
        <span class="card__label">Finition</span>
        {{ document.finish | capitalize }}
      </div>
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Créé</span>
        {{ getDate(document.created_at) }}
      </div>
      <div>
        <span class="card__label">Modifié</span>
        {{ getDate(document.updated_at) }}
      </div>
    </div>
  </div>
</template>

<script>
  import moment from 'moment'
  import mixins from '../../mixins'

  export default {
    props: {
      document: {
        type: Object,
        required: true
      }
    },
    mixins: [mixins],
    methods: {
      getDate(date) {
        return moment(date).locale(this.momentLocale).format(this.momentFormat)
      },
    }
  }
</script>