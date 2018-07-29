<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Affaires</h1>

      <div class="header__stats">
        <span v-if="meta.total > 1">{{ meta.total }} affaires</span>
        <span v-else-if="meta.total === 1">{{ meta.total }} affaire</span>
        <span v-else>Aucune affaire</span>
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

      <AddBusiness
        :companies="companies"
        :contacts="contacts"
        :user="user"
        :users="users"
        @business:created="addBusiness"/>
    </div>

    <div class="main__container main__container--grey">
      <Pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--top"
        @pagination:switched="getBusinesses"/>

      <template v-if="!businesses.length && !fetching">
        <p class="paragraph__no-model-found">Il n'existe encore aucune affaire.</p>
      </template>

      <template v-if="businesses.length && user.role === 'utilisateur'">
        <div class="user-business__container">
          <transition-group
            name="pagination"
            tag="div"
            mode="out-in">
            <UserBusiness
              v-for="(business, index) in businesses"
              :key="business.id"
              :business="business"
              :orders="orders"
              :user="user"
              @business:deleted="removeBusiness(index)"/>
          </transition-group>
        </div>
      </template>

      <template v-if="businesses.length && user.role === 'administrateur'">
        <transition-group
          name="pagination"
          tag="div"
          mode="out-in">
          <Business
            v-for="(business, index) in businesses"
            :key="business.id"
            :business="business"
            :companies="companies"
            :contacts="contacts"
            :user="user"
            :users="users"
            class="card__container"
            @business:deleted="removeBusiness(index)"/>
        </transition-group>
      </template>

      <Pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--bottom"
        @pagination:switched="getBusinesses"/>
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
import Business from "./Business.vue";
import UserBusiness from "./UserBusiness";
import AddBusiness from "./AddBusiness.vue";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";

import { loader } from "../../mixins";
import { eventBus } from "../../app";
import { mapGetters, mapActions } from "vuex";

export default {
  components: {
    Pagination,
    AppSelect,
    Business,
    UserBusiness,
    AddBusiness,
    MoonLoader
  },
  mixins: [loader],
  props: {
    companies: {
      type: Array,
      required: true
    },
    contacts: {
      type: Array,
      required: true
    },
    user: {
      type: Object,
      required: true
    },
    users: {
      type: Array,
      required: true
    },
    orders: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      businesses: [],
      meta: {},
      sort: "",
      sortOptions: [
        { label: "Aucun", value: "" },
        { label: "Nom", value: "name" },
        { label: "Référence", value: "reference" },
        { label: "Date de création", value: "created_at" }
      ],
      errors: {},
      fetching: false,
      modelNameSingular: "affaire",
      modelNamePlural: "affaires",
      modelGender: "F"
    };
  },
  computed: {
    ...mapGetters(["loaderState"])
  },
  created() {
    eventBus.$on("business:updated", data => this.updateBusiness(data));
  },
  mounted() {
    this.getBusinesses();
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    getBusinesses(page = 1) {
      this.toggleLoader();
      this.fetching = true;

      window.axios
        .get(window.route("api.businesses.index", this.sort.value), {
          params: {
            page
          }
        })
        .then(res => {
          this.businesses = res.data.data;
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
      this.getBusinesses();
    },
    addBusiness(business) {
      this.businesses.unshift(business);
      window.flash({
        message: "La création de l'affaire a réussi.",
        level: "success"
      });
    },
    updateBusiness(data) {
      for (let business of this.businesses) {
        if (data.id === business.id) {
          business.name = data.name;
          business.reference = data.reference;
          business.description = data.description;
          business.company_id = data.company_id;
          business.contact_id = data.contact_id;
        }
      }
      window.flash({
        message:
          "Les modifications apportées à l'affaire ont été enregistrées.",
        level: "success"
      });
    },
    removeBusiness(index) {
      this.businesses.splice(index, 1);
      window.flash({
        message: "Suppression de l'affaire réussie.",
        level: "success"
      });
    }
  }
};
</script>