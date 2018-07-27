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

      <add-company @companyWasCreated="addCompany"/>
    </div>

    <div class="main__container main__container--grey">
      <pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--top"
        @paginationSwitched="getCompanies"/>

      <template v-if="!companies.length && !fetching">
        <p class="paragraph__no-model-found">Il n'existe encore aucune société.</p>
      </template>

      <template v-else>
        <transition-group
          name="pagination"
          tag="div"
          mode="out-in">
          <company
            v-for="(company, index) in companies"
            :key="company.id"
            :company="company"
            class="card__container"
            @companyWasDeleted="removeCompany(index)"/>
        </transition-group>
      </template>

      <pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--bottom"
        @paginationSwitched="getCompanies"/>
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
import Company from "./Company.vue";
import AddCompany from "./AddCompany.vue";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import mixins from "../../mixins";
import { eventBus } from "../../app";
import { mapGetters } from "vuex";

export default {
  components: {
    Company,
    AddCompany,
    Pagination,
    AppSelect,
    MoonLoader
  },
  mixins: [mixins],
  data() {
    return {
      companies: [],
      meta: {},
      sort: "",
      sortOptions: [
        { label: "Aucun", value: "" },
        { label: "Nom", value: "name" },
        { label: "Status", value: "status" },
        { label: "Date de création", value: "created_at" }
      ],
      errors: {},
      fetching: false,
      modelNameSingular: "société",
      modelNamePlural: "sociétés",
      modelGender: "F"
    };
  },
  computed: {
    ...mapGetters(["loaderState"])
  },
  created() {
    eventBus.$on("companyWasUpdated", data => {
      this.updateCompany(data);
    });
  },
  mounted() {
    this.getCompanies();
  },
  methods: {
    getCompanies(page = 1) {
      this.$store.dispatch("toggleLoader");
      this.fetching = true;

      window.axios
        .get(window.route("api.companies.index", this.sort.value), {
          params: {
            page
          }
        })
        .then(response => {
          this.companies = response.data.data;
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
      this.getCompanies();
    },
    addCompany(company) {
      this.companies.unshift(company);
    },
    updateCompany(data) {
      for (let company of this.companies) {
        if (data.id === company.id) {
          company.name = data.name;
          company.status = data.status;
          company.description = data.description;
        }
      }
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
