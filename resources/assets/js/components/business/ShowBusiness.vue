<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">{{ business.name }}</h1>

      <button
        role="button"
        class="btn btn--red"
        @click.prevent="openEditPanel">
        <i class="fal fa-edit"/>
        Mettre à jour
      </button>
    </div>

    <div class="main__container main__container--grey">
      <div class="business__container">
        <div class="business__orders">
          <Order
            v-for="order in orders"
            :key="order.id"
            :order="order"
            :display-user="true"
            class="card__container card__container--full"/>
          <p
            v-if="!orders.length"
            class="paragraph__no-model-found paragraph__no-model-found--small">
            Aucune commande n'a été enregistrée pour cette affaire.
          </p>
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

    <!-- <EditBusiness
      :business="business"
      :contacts="contacts"
      :user="user"/> -->

    <transition name="fade">
      <div
        v-if="showModal"
        class="modal__background"
        @click.prevent="closePanels"/>
    </transition>

    <transition name="slide">
      <EditBusiness
        v-if="showEditPanel"
        :business="business"
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

import { mapGetters } from "vuex";
import { loader, modal, panels } from "../../mixins";

export default {
  components: {
    Order,
    EditBusiness,
    Comments,
    MoonLoader
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
  computed: {
    ...mapGetters(["loaderState"])
  },
  methods: {
    updateBusiness(data) {
      this.business = data;
      window.flash({
        message:
          "Les modifications apportées à l'affaire ont été enregistrées.",
        level: "success"
      });
    }
  }
};
</script>