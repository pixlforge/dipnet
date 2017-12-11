<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-10 my-5 mx-auto">
        <div class="row">
          <div class="col-12 d-flex flex-column flex-lg-row justify-content-between align-items-center center-on-small-only">
            <h1 class="mt-5">Formats</h1>
            <div class="mt-5">
              {{ formats.length }}
              {{ formats.length == 0 || formats.length == 1 ? 'format' : 'formats' }}
            </div>

            <!--Add-->
            <app-add-format @formatWasCreated="addFormat"></app-add-format>
          </div>
        </div>
      </div>
    </div>
    <div class="row bg-grey-light">
      <div class="col-10 mx-auto my-7">

        <!--Format-->
        <transition-group name="highlight">
          <app-format class="card card-custom center-on-small-only"
                      v-for="(format, index) in formats"
                      :data="format"
                      :key="format"
                      @formatWasDeleted="removeFormat(index)">
          </app-format>
        </transition-group>

        <!--Loader-->
        <app-moon-loader :loading="loaderState"
                         :color="loader.color"
                         :size="loader.size">
        </app-moon-loader>
      </div>
    </div>
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
    props: ['data'],
    data() {
      return {
        formats: this.data
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
