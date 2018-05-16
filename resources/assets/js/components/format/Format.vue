<template>
  <div>
    <div class="card__img">
      <img src="/img/placeholders/contact-bullet.jpg"
           alt="Bullet point image">
    </div>

    <div class="card__title">
      {{ format.name | capitalize }}
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Hauteur</span>
        {{ format.height }} mm
      </div>
      <div>
        <span class="card__label">Largeur</span>
        {{ format.width }} mm
      </div>
      <div>
        <span class="card__label">Surface</span>
        {{ widthTimesHeight }} mm<sup>2</sup>
      </div>
    </div>

    <div class="card__meta">
      <div>
        <span class="card__label">Créé</span>
        {{ getDate(format.created_at) }}
      </div>
      <div>
        <span class="card__label">Modifié</span>
        {{ getDate(format.updated_at) }}
      </div>
    </div>

    <div class="card__controls">
      <div title="Supprimer"
           role="button"
           @click="destroy">
        <i class="fal fa-times"></i>
      </div>
      <div title="Modifier">
        <edit-format :format="format"></edit-format>
      </div>
    </div>
  </div>
</template>

<script>
  import EditFormat from './EditFormat.vue'
  import moment from 'moment'
  import mixins from '../../mixins'

  export default {
    components: {
      EditFormat
    },
    props: {
      format: {
        type: Object,
        required: true
      }
    },
    computed: {
      widthTimesHeight() {
        return this.format.height * this.format.width
      }
    },
    mixins: [mixins],
    methods: {
      destroy() {
        axios.delete(route('formats.destroy', [this.format.id]))
        this.$emit('formatWasDeleted', this.format.id)
      },
      getDate(date) {
        return moment(date).locale(this.momentLocale).format(this.momentFormat)
      }
    }
  }
</script>
