<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Livraisons</h1>

      <div class="header__stats">
        <span v-text="modelCount"/>
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
import Pagination from "../pagination/Pagination";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import IllustrationNoData from "../illustrations/IllustrationNoData";

import { modelCount, loader } from "../../mixins";
import { mapGetters } from "vuex";

export default {
  components: {
    Delivery,
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
    getDeliveries(page = 1) {
      this.$store.dispatch("toggleLoader");
      this.fetching = true;

      window.axios
        .get(window.route("api.deliveries.index"), {
          params: {
            page
          }
        })
        .then(response => {
          this.deliveries = response.data.data;
          this.meta = response.data.meta;
          this.$store.dispatch("toggleLoader");
          this.fetching = false;
        })
        .catch(error => {
          this.errors = error.response.data;
          this.$store.dispatch("toggleLoader");
          this.fetching = false;
        });
    }
  }
};
</script>