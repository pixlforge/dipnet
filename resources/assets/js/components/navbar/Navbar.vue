<template>
  <div class="navbar">
    <div class="navbar__first-section">
      <div class="navbar__logo">
        <a :href="routeIndex">
          <img
            :src="logo"
            alt="Logo">
        </a>
      </div>
      <div class="navbar__searchbar">
        <Searchbar/>
      </div>
    </div>
    <div class="navbar__second-section">
      <div class="navbar__quicklinks">
        <ul class="navbar__links">
          <li>
            <a
              :href="routeOrders"
              :class="{'active': routeName.includes('orders') || routeName === 'index'}">
              Commandes
            </a>
          </li>
          <li>
            <a
              :href="routeBusinesses"
              :class="{'active': routeName.includes('businesses')}">
              Affaires
            </a>
          </li>
          <li>
            <a
              :href="routeContacts"
              :class="{'active': routeName.includes('contacts')}">
              Contacts
            </a>
          </li>
        </ul>
      </div>
      <div class="navbar__user-infos">
        <img
          v-if="avatarPath !== ''"
          :src="avatarPath"
          alt="Avatar">
        <img
          v-else
          :src="'/' + randomAvatar"
          alt="Avatar">
        <Menu
          :label="userName"
          :user-role="userRole"
          class="navbar__user-name"/>
        <div class="vertical-divider"/>
        <a
          :href="routeCompany"
          class="navbar__user-company">
          {{ userRole === 'administrateur' ? 'Admin' : userCompanyName }}
        </a>
      </div>
    </div>
  </div>
</template>

<script>
import Searchbar from "../search/Searchbar";
import Menu from "./Menu";

export default {
  components: {
    Searchbar,
    Menu
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
      if (this.appName === "Dipnet") {
        return "/img/logos/dip-logo-md.png";
      } else if (this.appName === "Multicop") {
        return "/img/logos/multicop-logo-md.png";
      }
    },
    routeIndex() {
      return window.route("index");
    },
    routeOrders() {
      return window.route("orders.index");
    },
    routeBusinesses() {
      if (this.userRole === "administrateur") {
        return window.route("admin.businesses.index");
      } else {
        return window.route("businesses.index");
      }
    },
    routeContacts() {
      if (this.userRole === "administrateur") {
        return window.route("admin.contacts.index");
      } else {
        return window.route("contacts.index");
      }
    },
    routeCompany() {
      if (this.userRole === "administrateur") {
        return window.route("admin.companies.index");
      } else {
        return window.route("companies.show", [this.userCompanyId]);
      }
    }
  }
};
</script>
