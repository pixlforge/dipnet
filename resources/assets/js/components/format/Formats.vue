<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Formats</h1>

      <!-- Count -->
      <div class="header__stats">
        <span v-text="modelCount"/>
      </div>

      <!-- Sort -->
      <AppSelect
        :options="sortOptions"
        v-model="sort"
        @input="selectSort(sort)">
        <span class="dropdown__title">Trier par</span>
        <span><strong>{{ sort ? sort.label : 'Aucun' }}</strong></span>
      </AppSelect>

      <!-- Add button -->
      <Button
        primary
        red
        long
        @click.prevent="openAddPanel">
        <i class="fal fa-plus-circle"/>
        Ajouter un format
      </Button>
    </div>

    <div class="main__container main__container--grey">
      <Pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--top"
        @pagination:switched="getFormats"/>

      <div
        v-if="!formats.length && !fetching"
        class="main__no-results">
        <p>Il n'existe encore aucun format.</p>
        <IllustrationNoData/>
      </div>

      <template v-else>
        <transition-group
          name="pagination"
          tag="div"
          mode="out-in">
          <Format
            v-for="(format, index) in formats"
            :key="format.id"
            :format="format"
            class="card__container"
            @edit-format:open="openEditPanel"
            @format:deleted="removeFormat(index)"/>
        </transition-group>
      </template>

      <Pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--bottom"
        @pagination:switched="getFormats"/>
    </div>

    <transition name="fade">
      <div
        v-if="showModal"
        class="modal__background"
        @click.prevent="closePanels"/>
    </transition>

    <transition name="slide">
      <AddFormat
        v-if="showAddPanel"
        @format:created="addFormat"
        @add-format:close="closePanels"/>
    </transition>

    <transition name="slide">
      <EditFormat
        v-if="showEditPanel"
        :format="modelToEdit"
        @format:updated="updateFormat"
        @edit-format:close="closePanels"/>
    </transition>

    <MoonLoader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import Format from "./Format.vue";
import Button from "../buttons/Button";
import AddFormat from "./AddFormat.vue";
import EditFormat from "./EditFormat.vue";
import AppSelect from "../select/AppSelect";
import Pagination from "../pagination/Pagination";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import IllustrationNoData from "../illustrations/IllustrationNoData";

import { mapGetters, mapActions } from "vuex";
import { loader, modal, panels, modelCount } from "../../mixins";

export default {
  components: {
    Format,
    Button,
    AddFormat,
    EditFormat,
    AppSelect,
    Pagination,
    MoonLoader,
    IllustrationNoData
  },
  mixins: [loader, modal, panels, modelCount],
  data() {
    return {
      formats: [],
      meta: {},
      errors: {},
      sort: "",
      sortOptions: [
        { label: "Aucun", value: "" },
        { label: "Nom", value: "name" },
        { label: "Hauteur", value: "height" },
        { label: "Largeur", value: "width" },
        { label: "Date de création", value: "created_at" }
      ],
      fetching: false,
      modelNameSingular: "format",
      modelNamePlural: "formats",
      modelGender: "M"
    };
  },
  computed: {
    ...mapGetters(["loaderState"])
  },
  mounted() {
    this.getFormats();
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    async getFormats(page = 1) {
      this.toggleLoader();
      this.fetching = true;
      try {
        let res = await window.axios.get(
          window.route("api.formats.index", this.sort.value),
          { params: { page } }
        );
        this.formats = res.data.data;
        this.meta = res.data.meta;
        this.fetching = false;
        this.toggleLoader();
      } catch (err) {
        this.errors = err.response.data;
        this.fetching = false;
        this.toggleLoader();
      }
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
      let index = this.formats.findIndex(format => format.id === data.id);
      this.formats[index] = data;
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
