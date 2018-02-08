<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">{{ dataBusiness.name }}</h1>
      <app-edit-business :data-business="dataBusiness"
                         :data-contacts="dataContacts"
                         :data-user="dataUser">
        <button class="btn btn--red">
          <i class="fal fa-pencil"></i>
          Modifier
        </button>
      </app-edit-business>
    </div>

    <div class="main__container main__container--grey">
      <div class="business__container">
        <div class="business__orders">
          <app-order class="card__container card__container--full"
                     v-for="(order, index) in dataOrders"
                     :key="order.id"
                     :data-order="order"
                     :display-user="true">
          </app-order>
          <p class="paragraph__no-model-found paragraph__no-model-found--small"
             v-if="!dataOrders.length">
            Aucune commande n'a été enregistrée pour cette affaire.
          </p>
        </div>
        <div class="business__comments">
          <app-comments :data-business="dataBusiness"
                        :data-avatar-path="dataAvatarPath"
                        :data-random-avatar="dataRandomAvatar"
                        :data-comments="dataComments"
                        :data-user="dataUser">
          </app-comments>
        </div>
      </div>
    </div>

    <app-moon-loader :loading="loaderState"
                     :color="loader.color"
                     :size="loader.size">
    </app-moon-loader>
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
    props: [
      'data-business',
      'data-contacts',
      'data-user',
      'data-orders',
      'data-avatar-path',
      'data-random-avatar',
      'data-comments'
    ],
    mixins: [mixins],
    components: {
      'app-order': Order,
      'app-edit-business': EditBusiness,
      'app-comments': Comments,
      'app-moon-loader': MoonLoader
    },
    computed: {
      ...mapGetters([
        'loaderState'
      ])
    },
  }
</script>