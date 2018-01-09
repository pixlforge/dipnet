<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Documents</h1>
      <div class="header__stats">
        {{ documents.length }}
        {{ documents.length == 0 || documents.length == 1 ? 'document' : 'documents' }}
      </div>
      <div></div>
    </div>

    <div class="main__container main__container--grey">
      <transition-group name="highlight" tag="div">
        <app-document class="card__container"
                      v-for="(document, index) in documents"
                      :key="index"
                      :data-document="document"
                      @documentWasDeleted="removeDocument(index)">
        </app-document>
      </transition-group>
    </div>

    <app-moon-loader :loading="loaderState"
                     :color="loader.color"
                     :size="loader.size">
    </app-moon-loader>
  </div>
</template>

<script>
  import Document from './Document'
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import mixins from '../../mixins'
  import { mapGetters } from 'vuex'

  export default {
    props: ['data-documents'],
    data() {
      return {
        documents: this.dataDocuments
      }
    },
    mixins: [mixins],
    components: {
      'app-document': Document,
      'app-moon-loader': MoonLoader
    },
    computed: {
      ...mapGetters([
        'loaderState'
      ])
    },
  }
</script>