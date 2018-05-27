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
      <pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--top"
        @paginationSwitched="getDeliveries"/>

      <template v-if="!deliveries.length && !fetching">
        <p class="paragraph__no-model-found">Il n'existe encore aucune livraison.</p>
      </template>

      <template v-else>
        <transition-group
          name="pagination"
          tag="div"
          mode="out-in">
          <delivery
            v-for="(delivery, index) in deliveries"
            :key="delivery.id"
            :delivery="delivery"
            class="card__container"
            @deliveryWasDeleted="removeDelivery(index)"/>
        </transition-group>
      </template>

      <pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--bottom"
        @paginationSwitched="getDeliveries"/>
    </div>

    <moon-loader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import Pagination from "../pagination/Pagination";
import Delivery from "./Delivery";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import mixins from "../../mixins";
import { mapGetters } from "vuex";

export default {
  components: {
    Delivery,
    Pagination,
    MoonLoader
  },
  mixins: [mixins],
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