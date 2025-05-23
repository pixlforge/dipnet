<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Tickers</h1>

      <!-- Count -->
      <div class="header__stats">
        <span v-text="modelCount"/>
      </div>

      <!-- Sort -->
      <div class="header__sort">
        <AppSelect
          :options="sortOptions"
          v-model="sort"
          @input="selectSort(sort)">
          <span class="dropdown__title">Trier par</span>
          <span><strong>{{ sort ? sort.label : 'Aucun' }}</strong></span>
        </AppSelect>
      </div>

      <!-- Add button -->
      <Button
        primary
        red
        long
        @click.prevent="openAddPanel">
        <i class="fal fa-plus-circle"/>
        Ajouter un ticker
      </Button>
    </div>

    <!-- Main content -->
    <main class="main__container">
      <section class="main__section">
        <Pagination
          v-if="meta.total > 25"
          :meta="meta"
          class="pagination pagination--top"
          @pagination:switched="getTickers"/>

        <div
          v-if="!tickers.length && !fetching"
          class="main__no-results">
          <p>Il n'existe encore aucun ticker.</p>
          <IllustrationNoData/>
        </div>

        <template v-else>
          <transition-group
            name="pagination"
            tag="div"
            mode="out-in">
            <Ticker
              v-for="(ticker, index) in tickers"
              :key="ticker.id"
              :ticker="ticker"
              @edit-ticker:open="openEditPanel"
              @ticker:deleted="removeTicker(index)"/>
          </transition-group>
        </template>

        <Pagination
          v-if="meta.total > 25"
          :meta="meta"
          class="pagination pagination--bottom"
          @pagination:switched="getTickers"/>
      </section>
    </main>

    <transition name="fade">
      <div
        v-if="showModal"
        class="modal__background"
        @click.prevent="closePanels"/>
    </transition>

    <transition name="slide">
      <AddTicker
        v-if="showAddPanel"
        @ticker:created="addTicker"
        @add-ticker:close="closePanels"/>
    </transition>

    <transition name="slide">
      <EditTicker
        v-if="showEditPanel"
        :ticker="modelToEdit"
        @ticker:updated="updateTicker"
        @edit-ticker:close="closePanels"/>
    </transition>

    <MoonLoader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import Ticker from "./Ticker";
import AddTicker from "./AddTicker";
import EditTicker from "./EditTicker";
import Button from "../buttons/Button";
import AppSelect from "../select/AppSelect";
import Pagination from "../pagination/Pagination";
import MoonLoader from "vue-spinner/src/MoonLoader";
import IllustrationNoData from "../illustrations/IllustrationNoData";

import { mapGetters, mapActions } from "vuex";
import { loader, modal, panels, modelCount } from "../../mixins";

export default {
  components: {
    Ticker,
    AddTicker,
    EditTicker,
    Button,
    AppSelect,
    Pagination,
    MoonLoader,
    IllustrationNoData
  },
  mixins: [loader, modal, panels, modelCount],
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
  mounted() {
    this.getTickers();
  },
  methods: {
    ...mapActions(["toggleLoader"]),
    async getTickers(page = 1) {
      this.toggleLoader();
      this.fetching = true;
      try {
        let res = await window.axios.get(
          window.route("api.tickers.index", this.sort.value),
          { params: { page } }
        );
        this.tickers = res.data.data;
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
    updateTicker(data) {
      let index = this.tickers.findIndex(ticker => ticker.id === data.id);
      if (data.active) {
        this.tickers.forEach(ticker => {
          if (ticker.id !== data.id) {
            ticker.active = false;
          }
        });
      }
      this.tickers[index] = data;
      window.flash({
        message:
          "Les modifications apportées à au ticker ont été enregistrées.",
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
