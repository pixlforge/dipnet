<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Sociétés</h1>

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

      <button
        role="button"
        class="btn btn--red-large"
        @click="openAddPanel">
        <i class="fal fa-plus-circle"/>
        Ajouter une société
      </button>
    </div>

    <div class="main__container main__container--grey">
      <Pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--top"
        @pagination:switched="getCompanies"/>

      <div
        v-if="!companies.length && !fetching"
        class="main__no-results">
        <p>Il n'existe encore aucune société.</p>
        <IllustrationNoData/>
      </div>

      <template v-else>
        <transition-group
          name="pagination"
          tag="div"
          mode="out-in">
          <Company
            v-for="(company, index) in companies"
            :key="company.id"
            :company="company"
            class="card__container"
            @edit-company:open="openEditPanel"
            @company:deleted="removeCompany(index)"/>
        </transition-group>
      </template>

      <Pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--bottom"
        @pagination:switched="getCompanies"/>
    </div>

    <transition name="fade">
      <div
        v-if="showModal"
        class="modal__background"
        @click.prevent="closePanels"/>
    </transition>

    <transition name="slide">
      <AddCompany
        v-if="showAddPanel"
        @company:created="addCompany"
        @add-company:close="closePanels"/>
    </transition>

    <transition name="slide">
      <EditCompany
        v-if="showEditPanel"
        :company="modelToEdit"
        @company:updated="updateCompany"
        @edit-company:close="closePanels"/>
    </transition>

    <MoonLoader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import Pagination from "../pagination/Pagination";
import AppSelect from "../select/AppSelect";
import AddCompany from "./AddCompany.vue";
import EditCompany from "./EditCompany.vue";
import Company from "./Company.vue";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import IllustrationNoData from "../illustrations/IllustrationNoData";

import { loader, modal, panels, modelCount } from "../../mixins";
import { mapGetters, mapActions } from "vuex";

export default {
  components: {
    Pagination,
    AppSelect,
    AddCompany,
    EditCompany,
    Company,
    MoonLoader,
    IllustrationNoData
  },
  mixins: [loader, modal, panels, modelCount],
  data() {
    return {
      companies: [],
      meta: {},
      errors: {},
      sort: "",
      sortOptions: [
        { label: "Aucun", value: "" },
        { label: "Nom", value: "name" },
        { label: "Status", value: "status" },
        { label: "Date de création", value: "created_at" }
      ],
      fetching: false,
      modelNameSingular: "société",
      modelNamePlural: "sociétés",
      modelGender: "F"
    };
  },
  computed: {
    ...mapGetters(["loaderState"])
  },
  mounted() {
    this.getCompanies();
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    async getCompanies(page = 1) {
      this.toggleLoader();
      this.fetching = true;
      try {
        let res = await window.axios.get(
          window.route("api.companies.index", this.sort.value),
          { params: { page } }
        );
        this.companies = res.data.data;
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
      this.getCompanies();
    },
    addCompany(company) {
      this.companies.unshift(company);
      window.flash({
        message: "La création de la société a réussi.",
        level: "success"
      });
    },
    updateCompany(data) {
      let index = this.companies.findIndex(company => company.id === data.id);
      this.companies[index] = data;
      window.flash({
        message:
          "Les modifications apportées à la société ont été enregistrées.",
        level: "success"
      });
    },
    removeCompany(index) {
      this.companies.splice(index, 1);
      window.flash({
        message: "Suppression de la société réussie.",
        level: "success"
      });
    }
  }
};
</script>
