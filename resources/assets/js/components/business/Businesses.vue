<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Affaires</h1>

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
        Ajouter une affaire
      </button>
    </div>

    <div class="main__container main__container--grey">
      <Pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--top"
        @pagination:switched="getBusinesses"/>

      <div
        v-if="!businesses.length && !fetching"
        class="main__no-results">
        <p>Il n'existe encore aucune affaire.</p>
        <IllustrationNoData/>
      </div>

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
              @edit-business:open="openEditPanel"
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
            @edit-business:open="openEditPanel"
            @business:deleted="removeBusiness(index)"/>
        </transition-group>
      </template>

      <Pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--bottom"
        @pagination:switched="getBusinesses"/>
    </div>

    <transition name="fade">
      <div
        v-if="showModal"
        class="modal__background"
        @click.prevent="closePanels"/>
    </transition>

    <transition name="slide">
      <AddBusiness
        v-if="showAddPanel"
        :companies="companies"
        :contacts="contacts"
        :user="user"
        :users="users"
        @business:created="addBusiness"
        @add-business:close="closePanels"/>
    </transition>

    <transition name="slide">
      <EditBusiness
        v-if="showEditPanel"
        :business="modelToEdit"
        :companies="companies"
        :contacts="contacts"
        :user="user"
        :users="users"
        @business:updated="updateBusiness"
        @edit-business:close="closePanels"/>
    </transition>

    <MoonLoader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import Business from "./Business.vue";
import UserBusiness from "./UserBusiness";
import AppSelect from "../select/AppSelect";
import AddBusiness from "./AddBusiness.vue";
import EditBusiness from "./EditBusiness.vue";
import Pagination from "../pagination/Pagination";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import IllustrationNoData from "../illustrations/IllustrationNoData";

import { mapGetters, mapActions } from "vuex";
import { loader, modal, panels, modelCount } from "../../mixins";

export default {
  components: {
    Business,
    UserBusiness,
    AppSelect,
    AddBusiness,
    EditBusiness,
    Pagination,
    MoonLoader,
    IllustrationNoData
  },
  mixins: [loader, modal, panels, modelCount],
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
      errors: {},
      sort: "",
      sortOptions: [
        { label: "Aucun", value: "" },
        { label: "Nom", value: "name" },
        { label: "Référence", value: "reference" },
        { label: "Date de création", value: "created_at" }
      ],
      fetching: false,
      modelNameSingular: "affaire",
      modelNamePlural: "affaires",
      modelGender: "F"
    };
  },
  computed: {
    ...mapGetters(["loaderState"])
  },
  mounted() {
    this.getBusinesses();
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    async getBusinesses(page = 1) {
      this.toggleLoader();
      this.fetching = true;
      try {
        let res = await window.axios.get(
          window.route("api.businesses.index", this.sort.value),
          { params: { page } }
        );
        this.businesses = res.data.data;
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
      let index = this.businesses.findIndex(
        business => business.id === data.id
      );
      this.businesses[index] = data;
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