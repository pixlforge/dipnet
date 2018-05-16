<template>
  <div class="navbar">
    <div class="navbar__first-section">
      <div class="navbar__logo">
        <a :href="routeIndex">
          <img :src="logo" alt="Logo">
        </a>
      </div>
      <div class="navbar__searchbar">
        <searchbar></searchbar>
      </div>
    </div>
    <div class="navbar__second-section">
      <div class="navbar__quicklinks">
        <ul class="navbar__links">
          <li>
            <a :href="routeOrders"
               :class="{'active': routeName.includes('orders') || routeName === 'index'}">
              Commandes
            </a>
          </li>
          <li>
            <a :href="routeBusinesses"
               :class="{'active': routeName.includes('businesses')}">
              Affaires
            </a>
          </li>
          <li>
            <a :href="routeContacts"
               :class="{'active': routeName.includes('contacts')}">
              Contacts
            </a>
          </li>
        </ul>
      </div>
      <div class="navbar__user-infos">
        <img :src="'/' + avatarPath" alt="Avatar" v-if="avatarPath !== ''">
        <img :src="'/' + randomAvatar" alt="Avatar" v-else>
        <menu-dropdown class="navbar__user-name"
                       :label="userName"
                       :user-role="userRole"></menu-dropdown>
        <div class="vertical-divider"></div>
        <a :href="routeCompany"
           class="navbar__user-company">
          {{ userRole === 'administrateur' ? 'Admin' : userCompanyName }}
        </a>
      </div>
    </div>
  </div>
</template>

<script>
  import Searchbar from '../search/Searchbar'
  import MenuDropdown from '../dropdown/MenuDropdown'

  export default {
    components: {
      Searchbar,
      MenuDropdown
    },
    props: {
      appName: {
        type: String,
        required: true
      },
      routeName: {
        type: String,
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
      userName: {
        type: String,
        required: true
      },
      userRole: {
        type: String,
        required: true
      },
      userCompanyName: {
        type: String,
        required: true
      },
      userCompanyId: {
        type: String,
        required: true
      }
    },
    computed: {
      logo() {
        if (this.appName === 'Dipnet') {
          return '/img/logos/dip-logo-md.png'
        } else if (this.appName === 'Multicop') {
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
        return route('companies.show', [this.userCompanyId])
      }
    }
  }
</script>
