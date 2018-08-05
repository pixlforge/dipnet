<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Livraisons</h1>

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

      <div/>
    </div>

    <div class="main__container main__container--grey">
      <Pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--top"
        @pagination:switched="getDeliveries"/>

      <div
        v-if="!deliveries.length && !fetching"
        class="main__no-results">
        <p>Il n'existe encore aucune livraison.</p>
        <IllustrationNoData/>
      </div>

      <template v-else>
        <transition-group
          name="pagination"
          tag="div"
          mode="out-in">
          <Delivery
            v-for="(delivery, index) in deliveries"
            :key="delivery.id"
            :delivery="delivery"
            class="card__container"
            @delivery:deleted="removeDelivery(index)"/>
        </transition-group>
      </template>

      <Pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--bottom"
        @pagination:switched="getDeliveries"/>
    </div>

    <MoonLoader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import Delivery from "./Delivery";
import AppSelect from "../select/AppSelect";
import Pagination from "../pagination/Pagination";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import IllustrationNoData from "../illustrations/IllustrationNoData";

import { modelCount, loader } from "../../mixins";
import { mapGetters, mapActions } from "vuex";

export default {
  components: {
    Delivery,
    AppSelect,
    Pagination,
    MoonLoader,
    IllustrationNoData
  },
  mixins: [modelCount, loader],
  data() {
    return {
      deliveries: [],
      meta: {},
      errors: {},
      sort: "",
      sortOptions: [
        { label: "Aucun", value: "" },
        { label: "Reference", value: "reference" },
        { label: "Date de création", value: "created_at" }
      ],
      fetching: false,
      modelNameSingular: "livraison",
      modelNamePlural: "livraisons",
      modelGender: "F"
    };
  },
  computed: {
    ...mapGetters(["loaderState"])
  },
  mounted() {
    this.getDeliveries();
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    async getDeliveries(page = 1) {
      this.toggleLoader();
      this.fetching = true;
      try {
        let res = await window.axios.get(
          window.route("api.deliveries.index", this.sort.value),
          { params: { page } }
        );
        this.deliveries = res.data.data;
        this.meta = res.data.meta;
        this.fetching = false;
        this.toggleLoader();
      } catch (err) {
        this.errors = err.response.data.errors;
        this.fetching = false;
        this.toggleLoader();
      }
    },
    selectSort(sort) {
      this.sort = sort;
      this.getDeliveries();
    }
  }
};
</script>