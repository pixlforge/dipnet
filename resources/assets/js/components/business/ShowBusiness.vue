<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">{{ currentBusiness.name }}</h1>

      <button
        role="button"
        class="btn btn--red"
        @click.prevent="openEditPanel">
        <i class="fal fa-edit"/>
        Mettre à jour
      </button>
    </div>

    <div
      v-if="business.description"
      class="header__container">
      <p class="paragraph__lead paragraph__lead--business-description">{{ currentBusiness.description }}</p>
    </div>

    <div class="main__container main__container--grey">
      <div class="business__container">
        <div class="business__orders">
          <h2 class="business__title">Commandes relatives</h2>
          <Order
            v-for="order in orders"
            :key="order.id"
            :order="order"
            :display-user="true"
            class="card__container card__container--full"/>
          <div
            v-if="!orders.length"
            class="main__no-results main__no-results--small">
            <p>Aucune commande n'existe actuellement pour cette affaire.</p>
            <IllustrationFileSearching/>
          </div>
        </div>
        <div class="business__comments">
          <Comments
            :business="business"
            :avatar-path="avatarPath"
            :random-avatar="randomAvatar"
            :comments="comments"
            :user="user"/>
        </div>
      </div>
    </div>

    <transition name="fade">
      <div
        v-if="showModal"
        class="modal__background"
        @click.prevent="closePanels"/>
    </transition>

    <transition name="slide">
      <EditBusiness
        v-if="showEditPanel"
        :business="currentBusiness"
        :contacts="contacts"
        :user="user"
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
import Order from "../order/Order";
import EditBusiness from "./EditBusiness";
import Comments from "../comment/Comments";
import MoonLoader from "vue-spinner/src/MoonLoader.vue";
import IllustrationFileSearching from "../illustrations/IllustrationFileSearching";

import { mapGetters } from "vuex";
import { loader, modal, panels } from "../../mixins";

export default {
  components: {
    Order,
    EditBusiness,
    Comments,
    MoonLoader,
    IllustrationFileSearching
  },
  mixins: [loader, modal, panels],
  props: {
    business: {
      type: Object,
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
    orders: {
      type: Array,
      required: true
    },
    avatarPath: {
      type: String,
      required: true
    },
    randomAvatar: {
      type: String,
      required: true
    },
    comments: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      currentBusiness: this.business
    };
  },
  computed: {
    ...mapGetters(["loaderState"])
  },
  methods: {
    updateBusiness(data) {
      this.currentBusiness = data;
      window.flash({
        message:
          "Les modifications apportées à l'affaire ont été enregistrées.",
        level: "success"
      });
    }
  }
};
</script>