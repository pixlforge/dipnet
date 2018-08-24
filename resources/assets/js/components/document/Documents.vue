<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Documents</h1>

      <div class="header__stats">
        <span v-text="modelCount"/>
      </div>

      <div/>
    </div>

    <!-- Main content -->
    <main class="main__container">
      <section class="main__section">
        <Pagination
          v-if="meta.total > 25"
          :meta="meta"
          class="pagination pagination--top"
          @pagination:switched="getDocuments"/>

        <div
          v-if="!documents.length && !fetching"
          class="main__no-results">
          <p>Il n'existe encore aucun document.</p>
          <IllustrationNoData/>
        </div>

        <template v-else>
          <transition-group
            name="pagination"
            tag="div"
            mode="out-in">
            <Document
              v-for="(document, index) in documents"
              :key="document.id"
              :document="document"
              @document:deleted="removeDocument(index)"/>
          </transition-group>
        </template>

        <Pagination
          v-if="meta.total > 25"
          :meta="meta"
          class="pagination pagination--bottom"
          @pagination:switched="getDocuments"/>
      </section>
    </main>

    <MoonLoader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import Document from "./Document";
import Pagination from "../pagination/Pagination";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import IllustrationNoData from "../illustrations/IllustrationNoData";

import { modelCount, loader } from "../../mixins";
import { mapGetters, mapActions } from "vuex";

export default {
  components: {
    Document,
    Pagination,
    MoonLoader,
    IllustrationNoData
  },
  mixins: [modelCount, loader],
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
    ...mapActions(["toggleLoader"]),
    getDocuments(page = 1) {
      this.toggleLoader();
      this.fetching = true;

      window.axios
        .get("/api/documents", {
          params: {
            page
          }
        })
        .then(res => {
          this.documents = res.data.data;
          this.meta = res.data.meta;
          this.toggleLoader();
          this.fetching = false;
        })
        .catch(err => {
          this.errors = err.response.data;
          this.toggleLoader();
          this.fetching = false;
        });
    }
  }
};
</script>