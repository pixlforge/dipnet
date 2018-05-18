<template>
  <div>
    <div class="header__container">
      <div class="profile__header">
        <h1 class="header__title">{{ user.username }}</h1>
        <div class="profile__icon profile__icon--success"
             v-if="user.email_confirmed">
          <i class="fal fa-check-circle"></i>
        </div>
        <div class="profile__icon profile__icon--warning"
             v-else>
          <i class="fal fa-times-circle"></i>
        </div>
      </div>

      <div class="profile__header profile__header--second">
        <p class="profile__header-item"
           v-if="!user.email_confirmed">
          Compte non vérifié
        </p>
        <send-confirmation-email-again class="profile__header-item"
                                       v-if="!user.email_confirmed"></send-confirmation-email-again>
        <update-profile class="profile__header-item"
                        :user="user"
                        :avatar="avatar"
                        :random-avatar="randomAvatar"></update-profile>
      </div>
    </div>

    <div class="profile__container">
      <div class="profile__box">

        <div class="profile__box-item">
          <div class="profile__avatar">
            <img :src="avatar" alt="Avatar" v-if="avatar">
            <img :src="randomAvatarPath" alt="Avatar" v-else>
          </div>
        </div>

        <div class="profile__box-item">
          <div class="profile__item">
            <h3>Adresse e-mail</h3>
            <p>{{ user.email }}</p>
          </div>
          <div class="profile__item">
            <h3>Création du compte</h3>
            <p>{{ getDate(user.created_at) }}</p>
          </div>
        </div>

        <div class="profile__box-item"
             v-if="userIsNotAdmin">
          <div class="profile__item">
            <h3>Membre de</h3>
            <p>{{ user.company.name }}</p>
          </div>
          <div class="profile__item">
            <h3>Réalisation de</h3>
            <span v-if="orders == 0">Aucune commande</span>
            <span v-if="orders == 1">{{ orders }} commande</span>
            <span v-if="orders > 1"> {{ orders }} commandes</span>
          </div>
          <div class="profile__item">
            <h3>Participe à</h3>
            <span v-if="businesses == 0">Aucune affaire</span>
            <span v-if="businesses == 1">{{ businesses }} affaire</span>
            <span v-if="businesses > 1"> {{ businesses }} affaires</span>
          </div>
        </div>
      </div>
    </div>

    <moon-loader :loading="loaderState"
                 :color="loader.color"
                 :size="loader.size"></moon-loader>
  </div>
</template>

<script>
  import SendConfirmationEmailAgain from '../register/SendConfirmationEmailAgain.vue'
  import UpdateProfile from './UpdateProfile.vue'
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import moment from 'moment'
  import mixins from '../../mixins'
  import { mapGetters } from 'vuex'

  export default {
    components: {
      SendConfirmationEmailAgain,
      UpdateProfile,
      MoonLoader
    },
    props: {
      user: {
        type: Object,
        required: true
      },
      orders: {
        type: Number,
        required: true
      },
      businesses: {
        type: Number,
        required: true
      },
      avatar: {
        type: String,
        required: true
      },
      randomAvatar: {
        type: String,
        required: true
      }
    },
    mixins: [mixins],
    computed: {
      ...mapGetters([
        'loaderState'
      ]),
      randomAvatarPath() {
        return 'img/placeholders/' + this.randomAvatar
      },
      userIsNotAdmin() {
        return this.user.role !== 'administrateur'
      }
    },
    methods: {
      getDate(date) {
        return moment(date).locale(this.momentLocale).format(this.momentFormat)
      }
    }
  }
</script>
