<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Documents</h1>

      <div class="header__stats">
        <span v-text="modelCount"/>
      </div>

      <div/>
    </div>

    <div class="main__container main__container--grey">
      <pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--top"
        @paginationSwitched="getDocuments"/>

      <template v-if="!documents.length && !fetching">
        <p class="paragraph__no-model-found">Il n'existe encore aucun document.</p>
      </template>

      <template v-else>
        <transition-group
          name="pagination"
          tag="div"
          mode="out-in">
          <document
            v-for="(document, index) in documents"
            :key="document.id"
            :document="document"
            class="card__container"
            @documentWasDeleted="removeDocument(index)"/>
        </transition-group>
      </template>

      <pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--bottom"
        @paginationSwitched="getDocuments"/>
    </div>

    <moon-loader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import Pagination from "../pagination/Pagination";
import Document from "./Document";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import mixins from "../../mixins";
import { mapGetters } from "vuex";

export default {
  components: {
    Document,
    Pagination,
    MoonLoader
  },
  mixins: [mixins],
  data() {
    return {
      documents: [],
      meta: {},
      errors: {},
      fetching: false,
      modelNameSingular: "document",
      modelNamePlural: "documents",
      modelGender: "M"
    };
  },
  computed: {
    ...mapGetters(["loaderState"])
  },
  mounted() {
    this.getDocuments();
  },
  methods: {
    getDocuments(page = 1) {
      this.$store.dispatch("toggleLoader");
      this.fetching = true;

      window.axios
        .get("/api/documents", {
          params: {
            page
          }
        })
        .then(response => {
          this.documents = response.data.data;
          this.meta = response.data.meta;
          this.$store.dispatch("toggleLoader");
          this.fetching = false;
        })
        .catch(error => {
          this.errors = error.response.data;
          this.$store.dispatch("toggleLoader");
          this.fetching = false;
        });
    }
  }
};
</script>