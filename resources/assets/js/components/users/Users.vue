<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Utilisateurs</h1>
      <div class="header__stats">
        {{ meta.total }}
        {{ meta.total == 0 || meta.total == 1 ? 'utilisateur' : 'utilisateurs' }}
      </div>
      <app-add-user :data-companies="dataCompanies"
                    @userWasCreated="addUser">
      </app-add-user>
    </div>

    <div class="main__container main__container--grey">
      <app-pagination class="pagination pagination--top"
                      :data-meta="meta"
                      @paginationSwitched="getUsers">
      </app-pagination>

      <transition-group name="pagination" tag="div" mode="out-in">
        <app-user class="card__container"
                  v-for="(user, index) in users"
                  :key="user.id"
                  :data-user="user"
                  :data-companies="companies"
                  @userWasDeleted="removeUser(index)">
        </app-user>
      </transition-group>

      <app-pagination class="pagination pagination--bottom"
                      :data-meta="meta"
                      @paginationSwitched="getUsers">
      </app-pagination>
    </div>

    <app-moon-loader :loading="loaderState"
                     :color="loader.color"
                     :size="loader.size">
    </app-moon-loader>
  </div>
</template>

<script>
  import Pagination from '../pagination/Pagination'
  import AddUser from './AddUser'
  import User from './User.vue'
  import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
  import mixins from '../../mixins'
  import { eventBus } from '../../app'
  import { mapGetters } from 'vuex'

  export default {
    props: [
      'data-companies'
    ],
    data() {
      return {
        users: [],
        companies: this.dataCompanies,
        meta: {}
      }
    },
    mixins: [mixins],
    components: {
      'app-user': User,
      'app-add-user': AddUser,
      'app-pagination': Pagination,
      'app-moon-loader': MoonLoader
    },
    computed: {
      ...mapGetters([
        'loaderState'
      ])
    },
    methods: {
      /**
       * Fetch the users paginated data.
       */
      getUsers(page = 1) {
        this.$store.dispatch('toggleLoader')

        axios.get(route('api.users.index'), {
          params: {
            page
          }
        }).then(response => {
          this.users = response.data.data
          this.meta = response.data.meta
          this.$store.dispatch('toggleLoader')
        })
      },

      /**
       * Add a new user.
       */
      addUser(user) {
        this.users.unshift(user)
        flash({
          message: "La création de l'utilisateur a réussi.",
          level: 'success'
        })
      },

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
    },
    mounted() {
      this.getUsers()
    }
  }
</script>
