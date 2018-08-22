<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Commandes</h1>

      <!-- Count -->
      <div class="header__stats">
        <span v-text="modelCount"/>
      </div>

      <!-- Create order -->
      <Button
        primary
        red
        long
        @click.prevent="redirect">
        <i class="fal fa-plus-circle"/>
        Nouvelle commande
      </Button>
    </div>

    <div class="main__container main__container--grey">
      <Pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--top"
        @pagination:switched="getOrders"/>

      <div
        v-if="!orders.length && !fetching"
        class="main__no-results">
        <p>Il n'existe encore aucune commande.</p>
        <IllustrationFileSearching/>
      </div>

      <template v-else>
        <transition-group
          name="pagination"
          tag="div"
          mode="out-in">
          <Order
            v-for="order in orders"
            :key="order.id"
            :order="order"
            :user-role="userRole"
            @orderWasDeleted="removeOrder"/>
        </transition-group>
      </template>

      <Pagination
        v-if="meta.total > 25"
        :meta="meta"
        class="pagination pagination--bottom"
        @pagination:switched="getOrders"/>
    </div>

    <MoonLoader
      :loading="loaderState"
      :color="loader.color"
      :size="loader.size"/>
  </div>
</template>

<script>
import Order from "./Order.vue";
import Button from "../buttons/Button";
import Pagination from "../pagination/Pagination";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import IllustrationFileSearching from "../illustrations/IllustrationFileSearching";

import { mapGetters } from "vuex";
import { loader, modelCount } from "../../mixins";

export default {
  components: {
    Order,
    Button,
    Pagination,
    MoonLoader,
    IllustrationFileSearching
  },
  mixins: [loader, modelCount],
  props: {
    userRole: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      orders: [],
      meta: {},
      errors: {},
      fetching: false,
      modelNameSingular: "commande",
      modelNamePlural: "commandes",
      modelGender: "F"
    };
  },
  computed: {
    ...mapGetters(["loaderState"])
  },
  mounted() {
    this.getOrders();
  },
  methods: {
    getOrders(page = 1) {
      this.$store.dispatch("toggleLoader");
      this.fetching = true;

      window.axios
        .get(window.route("api.orders.index"), {
          params: {
            page
          }
        })
        .then(response => {
          this.orders = response.data.data;
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
    redirect() {
      window.location = window.route("orders.create.start");
    },
    removeOrder(payload) {
      let index;
      index = this.orders.findIndex(order => {
        return order.id === payload.id;
      });
      this.orders.splice(index, 1);
      window.flash({
        message: "Suppression de la commande réussie.",
        level: "success"
      });
    }
  }
};
</script>
