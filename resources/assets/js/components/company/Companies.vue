<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Sociétés</h1>

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
        Ajouter une société
      </Button>
    </div>

    <!-- Main content -->
    <main class="main__container">
      <section class="main__section">
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
              @edit-company:open="openEditPanel"
              @company:deleted="removeCompany(index)"/>
          </transition-group>
        </template>

        <Pagination
          v-if="meta.total > 25"
          :meta="meta"
          class="pagination pagination--bottom"
          @pagination:switched="getCompanies"/>
      </section>
    </main>


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
import Company from "./Company.vue";
import Button from "../buttons/Button";
import AddCompany from "./AddCompany.vue";
import EditCompany from "./EditCompany.vue";
import AppSelect from "../select/AppSelect";
import Pagination from "../pagination/Pagination";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import IllustrationNoData from "../illustrations/IllustrationNoData";

import { mapGetters, mapActions } from "vuex";
import { loader, modal, panels, modelCount } from "../../mixins";

export default {
  components: {
    Company,
    Button,
    AddCompany,
    EditCompany,
    AppSelect,
    Pagination,
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
