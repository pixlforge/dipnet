<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Utilisateurs</h1>
      <div class="header__stats">
        {{ users.length }}
        {{ users.length == 0 || users.length == 1 ? 'utilisateur' : 'utilisateurs' }}
      </div>
      <div></div>
    </div>

    <div class="main__container main__container--grey">
      <transition-group name="highlight" tag="div">
        <app-user class="card__container"
                  v-for="(user, index) in users"
                  :key="index"
                  :data-user="user"
                  :data-companies="companies"
                  @userWasDeleted="removeUser(index)">
        </app-user>
      </transition-group>
    </div>

    <app-moon-loader :loading="loaderState"
                     :color="loader.color"
                     :size="loader.size">
    </app-moon-loader>
  </div>
</template>

<script>
  import User from './User.vue'
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import mixins from '../../mixins'
  import { eventBus } from '../../app'
  import { mapGetters } from 'vuex'

  export default {
    props: [
      'data-users',
      'data-companies'
    ],
    data() {
      return {
        users: this.dataUsers,
        companies: this.dataCompanies
      }
    },
    mixins: [mixins],
    components: {
      'app-user': User,
      'app-moon-loader': MoonLoader
    },
    computed: {
      ...mapGetters([
        'loaderState'
      ])
    },
    methods: {

      /**
       * Update the user details.
       */
      updateUser(data) {
        for (let user of this.users) {
          if (data.id === user.id) {
            user.username = data.username
          }
        }
        flash({
          message: 'Les modifications apportées à l\'utilisateur ont été enregistrées.',
          level: 'success'
        })
      },

      /**
       * Remove a user from the list.
       */
      removeUser(index) {
        this.users.splice(index, 1)
        flash({
          message: 'Suppression de l\'utilisateur réussie.',
          level: 'success'
        })
      }
    },
    created() {
      eventBus.$on('userWasUpdated', (data) => {
        this.updateUser(data)
      })
    }
  }
</script>
