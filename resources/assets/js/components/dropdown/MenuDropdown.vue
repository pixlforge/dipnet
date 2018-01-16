<template>
  <div ref="dropdownMenu">
    <div class="dropdown__label"
         @click="toggleOpen">
      <span>{{ label | capitalize }}</span>
    </div>
    <div class="dropdown__container" v-if="open">
      <ul class="dropdown__list">
        <li>
          <a :href="routeProfile">Profil</a>
        </li>
        <li>
          <a :href="routeLogout">Déconnexion</a>
        </li>
        <li class="dropdown__list-item-divider" v-if="userIsAdmin"></li>
        <li v-if="userIsAdmin">
          <a :href="routeCompanies">Sociétés</a>
        </li>
        <li v-if="userIsAdmin">
          <a :href="routeDeliveries">Livraisons</a>
        </li>
        <li v-if="userIsAdmin">
          <a :href="routeDocuments">Documents</a>
        </li>
        <li class="dropdown__list-item-divider" v-if="userIsAdmin"></li>
        <li v-if="userIsAdmin">
          <a :href="routeFormats">Formats</a>
        </li>
        <li v-if="userIsAdmin">
          <a :href="routeArticles">Articles</a>
        </li>
        <li v-if="userIsAdmin">
          <a :href="routeUsers">Utilisateurs</a>
        </li>
        <li>
          <a :href="routeLegacyApp" target="_blank" rel="noopener noreferrer">Ancienne application</a>
          <i class="fal fa-external-link"></i>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
  import mixins from '../../mixins'

  export default {
    props: [
      'label',
      'data-app-name',
      'data-user-role'
    ],
    data() {
      return {
        open: false
      }
    },
    mixins: [mixins],
    computed: {
      userIsAdmin() {
        return this.dataUserRole === 'administrateur'
      },

      routeProfile() {
        return route('profile.index')
      },

      routeLogout() {
        return route('logout')
      },

      routeCompanies() {
        return route('companies.index')
      },

      routeDeliveries() {
        return route('deliveries.index')
      },

      routeDocuments() {
        return route('documents.index')
      },

      routeFormats() {
        return route('formats.index')
      },

      routeArticles() {
        return route('articles.index')
      },

      routeUsers() {
        return route('users.index')
      },

      routeLegacyApp() {
        if (this.dataAppName === 'Dipnet') {
          return 'http://dipnet.dip.ch/'
        } else if (this.dataAppName === 'Multicop') {
          return 'http://multiprint.multicop.ch/'
        }
      },
    },
    methods: {
      /**
       * Toggle the open state of the dropdown list.
       */
      toggleOpen() {
        this.open = !this.open
      },

      /**
       * Retrieve the reference of the active dropdown and close
       * it if another element is clicked.
       */
      documentClick(event) {
        let el = this.$refs.dropdownMenu
        let target = event.target
        if ((el !== target) && !el.contains(target)) {
          this.open = false
        }
      }
    },
    created() {
      document.addEventListener('click', this.documentClick)
    },
    destroyed() {
      document.removeEventListener('click', this.documentClick)
    }
  }
</script>