<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Formats</h1>
      <div class="header__stats">
        {{ formats.length }}
        {{ formats.length == 0 || formats.length == 1 ? 'format' : 'formats' }}
      </div>
      <app-add-format @formatWasCreated="addFormat">
      </app-add-format>
    </div>

    <div class="main__container main__container--grey">
      <transition-group name="highlight" tag="div">
        <app-format class="card__container"
                    v-for="(format, index) in formats"
                    :key="index"
                    :data-format="format"
                    @formatWasDeleted="removeFormat(index)">
        </app-format>
      </transition-group>
    </div>

    <app-moon-loader :loading="loaderState"
                     :color="loader.color"
                     :size="loader.size">
    </app-moon-loader>
  </div>
</template>

<script>
  import Format from './Format.vue'
  import AddFormat from './AddFormat.vue'
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import mixins from '../../mixins'
  import { eventBus } from '../../app'
  import { mapGetters } from 'vuex'

  export default {
    props: ['data-formats'],
    data() {
      return {
        formats: this.dataFormats
      }
    },
    components: {
      'app-format': Format,
      'app-add-format': AddFormat,
      'app-moon-loader': MoonLoader
    },
    mixins: [mixins],
    computed: {
      ...mapGetters([
        'loaderState'
      ])
    },
    methods: {
      /**
       * Add a new format to the list.
       */
      addFormat(format) {
        this.formats.unshift(format)
        flash({
          message: 'La création du format a réussi.',
          level: 'success'
        })
      },

      /**
       * Update the format.
       */
      updateFormat(data) {
        for (let format of this.formats) {
          if (data.id === format.id) {
            format.name = data.name
            format.height = data.height
            format.width = data.width
            format.surface = data.surface
          }
        }
        flash({
          message: 'Les modifications apportées au format ont été enregistrées.',
          level: 'success'
        })
      },

      /**
       * Remove a format from the list.
       */
      removeFormat(index) {
        this.formats.splice(index, 1)
        flash({
          message: 'Suppression du format réussie.',
          level: 'success'
        })
      }
    },
    created() {
      eventBus.$on('formatWasUpdated', (data) => {
        this.updateFormat(data)
      })
    }
  }
</script>
