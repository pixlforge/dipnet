<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Livraisons</h1>
      <div class="header__stats">
        {{ deliveries.length }}
        {{ deliveries.length == 0 || deliveries.length == 1 ? 'livraison' : 'livraisons' }}
      </div>
      <div></div>
    </div>

    <div class="main__container main__container--grey">
      <transition-group name="highlight" tag="div">
        <app-delivery class="card__container"
                      v-for="(delivery, index) in deliveries"
                      :key="index"
                      :data-delivery="delivery"
                      @deliveryWasDeleted="removeDelivery(index)">
        </app-delivery>
      </transition-group>
    </div>

    <app-moon-loader :loading="loaderState"
                     :color="loader.color"
                     :size="loader.size">
    </app-moon-loader>
  </div>
</template>

<script>
  import Delivery from './Delivery'
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import mixins from '../../mixins'
  import { mapGetters } from 'vuex'

  export default {
    props: ['data-deliveries'],
    data() {
      return {
        deliveries: this.dataDeliveries
      }
    },
    mixins: [mixins],
    components: {
      'app-delivery': Delivery,
      'app-moon-loader': MoonLoader
    },
    computed: {
      ...mapGetters([
        'loaderState'
      ])
    },
  }
</script>