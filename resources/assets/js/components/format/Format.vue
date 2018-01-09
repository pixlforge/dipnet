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
        {{ format.height | capitalize | mm }}
      </div>
      <div>
        <span class="card__label">Largeur</span>
        {{ format.width | capitalize | mm }}
      </div>
      <div>
        <span class="card__label">Surface</span>
        {{ format.surface | capitalize | mm }}<sup>2</sup>
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
      <div>
        <app-edit-format :data-format="format">
        </app-edit-format>
      </div>
      <div @click="destroy">
        <i class="fal fa-times"></i>
      </div>
    </div>
  </div>
</template>

<script>
  import EditFormat from './EditFormat.vue'
  import moment from 'moment'
  import mixins from '../../mixins'

  export default {
    props: ['data-format'],
    data() {
      return {
        format: this.dataFormat
      }
    },
    mixins: [mixins],
    components: {
      'app-edit-format': EditFormat
    },
    filters: {
      mm(value) {
        return value.concat('mm')
      }
    },
    methods: {
      /**
       * Delete a format.
       */
      destroy() {
        axios.delete(route('formats.destroy', [this.format.id]))
        this.$emit('formatWasDeleted', this.format.id)
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
