<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Tickers</h1>

      <div class="header__stats">
        <span v-text="modelCount"/>
      </div>

      <add-ticker
        :tickers="tickers"
        @tickerWasCreated="addTicker"/>
    </div>

    <div class="main__container main__container--grey">
      <pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--top"
        @paginationSwitched="getTickers"/>

      <template v-if="!tickers.length && !fetching">
        <p class="paragraph__no-model-found">Il n'existe encore aucun ticker.</p>
      </template>

      <template v-else>
        <transition-group
          name="pagination"
          tag="div"
          mode="out-in">
          <ticker
            v-for="(ticker, index) in tickers"
            :key="ticker.id"
            :ticker="ticker"
            class="card__container"
            @tickertWasDeleted="removeTicker(index)"/>
        </transition-group>
      </template>

      <pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--bottom"
        @paginationSwitched="getTickers"/>
    </div>

    <moon-loader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import Pagination from "../pagination/Pagination";
import AddTicker from "./AddTicker";
import Ticker from "./Ticker";
import MoonLoader from "vue-spinner/src/MoonLoader";
import mixins from "../../mixins";
import { eventBus } from "../../app";
import { mapGetters } from "vuex";

export default {
  components: {
    Pagination,
    AddTicker,
    Ticker,
    MoonLoader
  },
  mixins: [mixins],
  data() {
    return {
      tickers: [],
      meta: {},
      errors: {},
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
        .get(window.route("api.tickers.index"), {
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
    }
  }
};
</script>

