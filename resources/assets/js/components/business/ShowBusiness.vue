<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">{{ business.name }}</h1>
      <edit-business :business="business"
                     :contacts="contacts"
                     :user="user">
        <button class="btn btn--red"
                role="button">
          <i class="fal fa-pencil"></i>
          Modifier
        </button>
      </edit-business>
    </div>

    <div class="main__container main__container--grey">
      <div class="business__container">
        <div class="business__orders">
          <order class="card__container card__container--full"
                 v-for="(order, index) in orders"
                 :key="order.id"
                 :order="order"
                 :display-user="true"></order>
          <p class="paragraph__no-model-found paragraph__no-model-found--small"
             v-if="!orders.length">
            Aucune commande n'a été enregistrée pour cette affaire.
          </p>
        </div>
        <div class="business__comments">
          <comments :business="business"
                    :avatar-path="avatarPath"
                    :random-avatar="randomAvatar"
                    :comments="comments"
                    :user="user">
          </comments>
        </div>
      </div>
    </div>

    <moon-loader :loading="loaderState"
                 :color="loader.color"
                 :size="loader.size"></moon-loader>
  </div>
</template>

<script>
  import Comments from '../comment/Comments'
  import Order from '../order/Order'
  import EditBusiness from './EditBusiness'
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import mixins from '../../mixins'
  import { mapGetters } from 'vuex'

  export default {
    components: {
      Comments,
      Order,
      EditBusiness,
      MoonLoader
    },
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
    mixins: [mixins],
    computed: {
      ...mapGetters([
        'loaderState'
      ])
    },
  }
</script>