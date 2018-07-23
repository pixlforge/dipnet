<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Formats</h1>

      <div class="header__stats">
        <span v-text="modelCount"/>
      </div>

      <div>
        <AppSelect
          :options="sortOptions"
          v-model="sort"
          @input="selectSort(sort)">
          <span class="dropdown__title">Trier par</span>
          <span><strong>{{ sort ? sort.label : 'Aucun' }}</strong></span>
        </AppSelect>
      </div>

      <add-format @formatWasCreated="addFormat"/>
    </div>

    <div class="main__container main__container--grey">
      <pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--top"
        @paginationSwitched="getFormats"/>

      <template v-if="!formats.length && !fetching">
        <p class="paragraph__no-model-found">Il n'existe encore aucun format.</p>
      </template>

      <template v-else>
        <transition-group
          name="pagination"
          tag="div"
          mode="out-in">
          <format
            v-for="(format, index) in formats"
            :key="format.id"
            :format="format"
            class="card__container"
            @formatWasDeleted="removeFormat(index)"/>
        </transition-group>
      </template>

      <pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--bottom"
        @paginationSwitched="getFormats"/>
    </div>

    <moon-loader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import Pagination from "../pagination/Pagination";
import AppSelect from "../select/AppSelect";
import Format from "./Format.vue";
import AddFormat from "./AddFormat.vue";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import mixins from "../../mixins";
import { eventBus } from "../../app";
import { mapGetters } from "vuex";

export default {
  components: {
    Format,
    AddFormat,
    Pagination,
    AppSelect,
    MoonLoader
  },
  mixins: [mixins],
  data() {
    return {
      formats: [],
      meta: {},
      sort: "",
      sortOptions: [
        { label: "Aucun", value: "" },
        { label: "Nom", value: "name" },
        { label: "Hauteur", value: "height" },
        { label: "Largeur", value: "width" },
        { label: "Date de création", value: "created_at" }
      ],
      errors: {},
      fetching: false,
      modelNameSingular: "format",
      modelNamePlural: "formats",
      modelGender: "M"
    };
  },
  computed: {
    ...mapGetters(["loaderState"])
  },
  created() {
    eventBus.$on("formatWasUpdated", data => {
      this.updateFormat(data);
    });
  },
  mounted() {
    this.getFormats();
  },
  methods: {
    getFormats(page = 1) {
      this.$store.dispatch("toggleLoader");
      this.fetching = true;

      window.axios
        .get(window.route("api.formats.index", this.sort.value), {
          params: {
            page
          }
        })
        .then(response => {
          this.formats = response.data.data;
          this.meta = response.data.meta;
          this.$store.dispatch("toggleLoader");
          this.fetching = false;
        })
        .catch(error => {
          this.errors = error.response.data;
          this.$store.dispatch("toggleLoader");
          this.fetching = false;
        });
    },
    selectSort(sort) {
      this.sort = sort;
      this.getFormats();
    },
    addFormat(format) {
      this.formats.unshift(format);
      window.flash({
        message: "La création du format a réussi.",
        level: "success"
      });
    },
    updateFormat(data) {
      for (let format of this.formats) {
        if (data.id === format.id) {
          format.name = data.name;
          format.height = data.height;
          format.width = data.width;
          format.surface = data.surface;
        }
      }
      window.flash({
        message: "Les modifications apportées au format ont été enregistrées.",
        level: "success"
      });
    },
    removeFormat(index) {
      this.formats.splice(index, 1);
      window.flash({
        message: "Suppression du format réussie.",
        level: "success"
      });
    }
  }
};
</script>
