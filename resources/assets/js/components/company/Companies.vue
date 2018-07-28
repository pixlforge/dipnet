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

      <AddCompany @company:created="addCompany"/>
    </div>

    <div class="main__container main__container--grey">
      <Pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--top"
        @pagination:switched="getCompanies"/>

      <template v-if="!companies.length && !fetching">
        <p class="paragraph__no-model-found">Il n'existe encore aucune société.</p>
      </template>

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
            @company:deleted="removeCompany(index)"/>
        </transition-group>
      </template>

      <Pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--bottom"
        @pagination:switched="getCompanies"/>
    </div>

    <MoonLoader
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

import { eventBus } from "../../app";
import { mapGetters, mapActions } from "vuex";

export default {
  components: {
    Pagination,
    AppSelect,
    Company,
    AddCompany,
    MoonLoader
  },
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
    eventBus.$on("company:created", data => {
      this.updateCompany(data);
    });
  },
  mounted() {
    this.getCompanies();
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    getCompanies(page = 1) {
      this.toggleLoader();
      this.fetching = true;
      window.axios
        .get(window.route("api.companies.index", this.sort.value), {
          params: {
            page
          }
        })
        .then(res => {
          this.companies = res.data.data;
          this.meta = res.data.meta;
          this.toggleLoader();
          this.fetching = false;
        })
        .catch(err => {
          this.errors = err.response.data;
          this.toggleLoader();
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
