<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Documents</h1>

      <div class="header__stats">
        <span v-text="modelCount"></span>
      </div>

      <div></div>
    </div>

    <div class="main__container main__container--grey">
      <pagination class="pagination pagination--top"
                  v-if="meta.total > 25"
                  :data-meta="meta"
                  @paginationSwitched="getDocuments"></pagination>

      <template v-if="!documents.length && !fetching">
        <p class="paragraph__no-model-found">Il n'existe encore aucun document.</p>
      </template>

      <template v-else>
        <transition-group name="pagination" tag="div" mode="out-in">
          <document class="card__container"
                    v-for="(document, index) in documents"
                    :key="document.id"
                    :document="document"
                    @documentWasDeleted="removeDocument(index)"></document>
        </transition-group>
      </template>

      <pagination class="pagination pagination--bottom"
                  v-if="meta.total > 25"
                  :data-meta="meta"
                  @paginationSwitched="getDocuments"></pagination>
    </div>

    <moon-loader :loading="loaderState"
                 :color="loader.color"
                 :size="loader.size"></moon-loader>
  </div>
</template>

<script>
  import Pagination from '../pagination/Pagination'
  import Document from './Document'
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import mixins from '../../mixins'
  import { mapGetters } from 'vuex'

  export default {
    components: {
      Document,
      Pagination,
      MoonLoader
    },
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
    computed: {
      ...mapGetters([
        'loaderState'
      ])
    },
    mixins: [mixins],
    methods: {
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