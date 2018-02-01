<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Documents</h1>
      <div class="header__stats">
        {{ meta.total }}
        {{ meta.total == 0 || meta.total == 1 ? 'document' : 'documents' }}
      </div>
      <div></div>
    </div>

    <div class="main__container main__container--grey">
      <app-pagination class="pagination pagination--top"
                      :data-meta="meta"
                      @paginationSwitched="getDocuments">
      </app-pagination>

      <transition-group name="pagination" tag="div" mode="out-in">
        <app-document class="card__container"
                      v-for="(document, index) in documents"
                      :key="document.id"
                      :data-document="document"
                      @documentWasDeleted="removeDocument(index)">
        </app-document>
      </transition-group>

      <app-pagination class="pagination pagination--bottom"
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
        meta: {}
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

        axios.get('/api/documents', {
          params: {
            page
          }
        }).then(response => {
          this.documents = response.data.data
          this.meta = response.data.meta
          this.$store.dispatch('toggleLoader')
        })
      },
    },
    mounted() {
      this.getDocuments()
    }
  }
</script>