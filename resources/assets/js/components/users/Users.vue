<template>
  <div>
    <div class="header__container">
      <h1 class="header__title">Utilisateurs</h1>

      <div class="header__stats">
        <span v-text="modelCount"></span>
      </div>

      <add-user :companies="companies"
                @userWasCreated="addUser"></add-user>
    </div>

    <div class="main__container main__container--grey">
      <pagination class="pagination pagination--top"
                  v-if="meta.total > 25"
                  :meta="meta"
                  @paginationSwitched="getUsers"></pagination>

      <transition-group name="pagination" tag="div" mode="out-in">
        <user class="card__container"
              v-for="(user, index) in users"
              :key="user.id"
              :user="user"
              :companies="companies"
              @userWasDeleted="removeUser(index)"></user>
      </transition-group>

      <pagination class="pagination pagination--bottom"
                  v-if="meta.total > 25"
                  :meta="meta"
                  @paginationSwitched="getUsers"></pagination>
    </div>

    <moon-loader :loading="loaderState"
                 :color="loader.color"
                 :size="loader.size"></moon-loader>
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
    components: {
      User,
      AddUser,
      Pagination,
      MoonLoader
    },
    props: {
      companies: {
        type: Array,
        required: true
      }
    },
    data() {
      return {
        users: [],
        meta: {},
        modelNameSingular: 'utilisateur',
        modelNamePlural: 'utilisateurs',
        modelGender: 'M'
      }
    },
    computed: {
      ...mapGetters([
        'loaderState'
      ])
    },
    mixins: [mixins],
    methods: {
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
      addUser(user) {
        this.users.unshift(user)
        flash({
          message: "La création de l'utilisateur a réussi.",
          level: 'success'
        })
      },
      updateUser(data) {
        for (let user of this.users) {
          if (data.id === user.id) {
            user.username = data.username
            user.email = data.email
            user.role = data.role
          }
        }
        flash({
          message: "Les modifications apportées à l'utilisateur ont été enregistrées.",
          level: 'success'
        })
      },
      removeUser(index) {
        this.users.splice(index, 1)
        flash({
          message: "Suppression de l'utilisateur réussie.",
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
