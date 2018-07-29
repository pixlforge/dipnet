<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Tickers</h1>

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

      <AddTicker
        :tickers="tickers"
        @ticker:created="addTicker"/>
    </div>

    <div class="main__container main__container--grey">
      <Pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--top"
        @pagination:switched="getTickers"/>

      <template v-if="!tickers.length && !fetching">
        <p class="paragraph__no-model-found">Il n'existe encore aucun ticker.</p>
      </template>

      <template v-else>
        <transition-group
          name="pagination"
          tag="div"
          mode="out-in">
          <Ticker
            v-for="(ticker, index) in tickers"
            :key="ticker.id"
            :ticker="ticker"
            class="card__container"
            @ticker:deleted="removeTicker(index)"/>
        </transition-group>
      </template>

      <Pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--bottom"
        @pagination:switched="getTickers"/>
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
import AddTicker from "./AddTicker";
import Ticker from "./Ticker";
import MoonLoader from "vue-spinner/src/MoonLoader";

import { loader, modelCount } from "../../mixins";
import { eventBus } from "../../app";
import { mapGetters } from "vuex";

export default {
  components: {
    Pagination,
    AppSelect,
    AddTicker,
    Ticker,
    MoonLoader
  },
  mixins: [loader, modelCount],
  data() {
    return {
      tickers: [],
      meta: {},
      errors: {},
      sort: "",
      sortOptions: [
        { label: "Aucun", value: "" },
        { label: "Actif", value: "active" },
        { label: "Date de création", value: "created_at" }
      ],
      fetching: false,
      modelNameSingular: "ticker",
      modelNamePlural: "tickers",
      modelGender: "M"
    };
  },
  computed: {
    ...mapGetters(["loaderState"])
  },
  created() {
    eventBus.$on("tickerWasUpdated", data => {
      if (data.active) {
        this.tickers.forEach(item => {
          if (item.id !== data.id) {
            item.active = false;
          }
        });
      }
    });
  },
  mounted() {
    this.getTickers();
  },
  methods: {
    getTickers(page = 1) {
      this.$store.dispatch("toggleLoader");
      this.fetching = true;

      window.axios
        .get(window.route("api.tickers.index", this.sort.value), {
          params: {
            page
          }
        })
        .then(res => {
          this.tickers = res.data.data;
          this.meta = res.data.meta;
          this.$store.dispatch("toggleLoader");
          this.fetching = false;
        })
        .catch(err => {
          this.errors = err.response.data;
          this.$store.dispatch("toggleLoader");
          this.fetching = false;
        });
    },
    selectSort(sort) {
      this.sort = sort;
      this.getTickers();
    },
    addTicker(ticker) {
      if (ticker.active) {
        this.tickers.forEach(item => {
          item.active = false;
        });
      }
      this.tickers.unshift(ticker);
      window.flash({
        message: "La création du ticker a réussi.",
        level: "success"
      });
    },
    removeTicker(index) {
      this.tickers.splice(index, 1);
      window.flash({
        message: "Suppression du ticker réussie.",
        level: "success"
      });
    }
  }
};
</script>
