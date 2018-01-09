<template>
  <div class="navbar">
    <div class="navbar__first-section">
      <div class="navbar__logo">
        <a :href="routeIndex">
          <img :src="logo" alt="Logo">
        </a>
      </div>
      <div class="navbar__searchbar">
        <app-searchbar></app-searchbar>
      </div>
    </div>
    <div class="navbar__second-section">
      <div class="navbar__quicklinks">
        <ul class="navbar__links">
          <li>
            <a :href="routeOrders"
               :class="{'active': dataRouteName.includes('orders') || dataRouteName === 'index'}">
              Commandes
            </a>
          </li>
          <li>
            <a :href="routeBusinesses"
               :class="{'active': dataRouteName.includes('businesses')}">
              Affaires
            </a>
          </li>
          <li>
            <a :href="routeContacts"
               :class="{'active': dataRouteName.includes('contacts')}">
              Contacts
            </a>
          </li>
        </ul>
      </div>
      <div class="navbar__user-infos">
        <img :src="'/' + dataAvatarPath" alt="Avatar" v-if="dataAvatarPath !== ''">
        <img :src="'/' + dataRandomAvatar" alt="Avatar" v-else>
        <app-menu-dropdown class="navbar__user-name" :label="dataUserName"
                           :data-app-name="dataAppName"
                           :data-user-role="dataUserRole">
        </app-menu-dropdown>
        <div class="vertical-divider"></div>
        <a :href="routeCompany" class="navbar__user-company">{{ dataUserCompanyName }}</a>
      </div>
    </div>
  </div>
</template>

<script>
  import Searchbar from '../search/Searchbar'
  import MenuDropdown from '../dropdown/MenuDropdown'

  export default {
    props: [
      'data-app-name',
      'data-route-name',
      'data-avatar-path',
      'data-random-avatar',
      'data-user-name',
      'data-user-role',
      'data-user-company-name',
      'data-user-company-id'
    ],
    components: {
      'app-searchbar': Searchbar,
      'app-menu-dropdown': MenuDropdown
    },
    computed: {
      logo() {
        if (this.dataAppName === 'Dipnet') {
          return '/img/logos/dip-logo-md.png'
        } else if (this.dataAppName === 'Multicop') {
          return '/img/logos/multicop-logo-md.png'
        }
      },

      routeIndex() {
        return route('index')
      },

      routeOrders() {
        return route('orders.index')
      },

      routeBusinesses() {
        return route('businesses.index')
      },

      routeContacts() {
        return route('contacts.index')
      },

      routeCompany() {
        return route('companies.show', [this.dataUserCompanyId])
      }
    },
    created() {
    }
  }
</script>