<template>
  <div>
    <div class="header__container">

      <!--Page title-->
      <h1 class="header__title">Documents</h1>

      <!--Documents count-->
      <div class="header__stats">
        <span v-text="modelCount"></span>
      </div>

      <div></div>
    </div>

    <div class="main__container main__container--grey">

      <!--Pagination top -->
      <app-pagination class="pagination pagination--top"
                      v-if="meta.total > 25"
                      :data-meta="meta"
                      @paginationSwitched="getDocuments">
      </app-pagination>

      <template v-if="!documents.length && !fetching">
        <p class="paragraph__no-model-found">Il n'existe encore aucun document.</p>
      </template>

      <template v-else>
        <transition-group name="pagination" tag="div" mode="out-in">
          <app-document class="card__container"
                        v-for="(document, index) in documents"
                        :key="document.id"
                        :data-document="document"
                        @documentWasDeleted="removeDocument(index)">
          </app-document>
        </transition-group>
      </template>

      <!--Pagination bottom-->
      <app-pagination class="pagination pagination--bottom"
                      v-if="meta.total > 25"
                      :data-meta="meta"
                      @paginationSwitched="getDocuments">
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
  import Document from './Document'
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import mixins from '../../mixins'
  import { mapGetters } from 'vuex'

  export default {
    data() {
      return {
        documents: [],
        meta: {},
        errors: {},
        fetching: false,
        modelNameSingular: 'document',
        modelNamePlural: 'documents',
        modelGender: 'M'
      }
    },
    mixins: [mixins],
    components: {
      'app-document': Document,
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
       * Fetch the documents paginated data.
       */
      getDocuments(page = 1) {
        this.$store.dispatch('toggleLoader')
        this.fetching = true

        axios.get('/api/documents', {
          params: {
            page
          }
        }).then(response => {
          this.documents = response.data.data
          this.meta = response.data.meta
          this.$store.dispatch('toggleLoader')
          this.fetching = false
        }).catch(error => {
          this.errors = error.response.data
          this.$store.dispatch('toggleLoader')
          this.fetching = false
        })
      },
    },
    mounted() {
      this.getDocuments()
    }
  }
</script>