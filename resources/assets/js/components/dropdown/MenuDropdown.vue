<template>
  <div ref="dropdownMenu">
    <div
      class="dropdown__label"
      role="button"
      @click="toggleOpen">
      <span>{{ label | capitalize }}</span>
    </div>
    <div
      v-if="open"
      class="dropdown__container">
      <ul class="dropdown__list">
        <li>
          <a :href="routeProfile">Profil</a>
        </li>
        <li>
          <a :href="routeLogout">Déconnexion</a>
        </li>
        <li
          v-if="userIsAdmin"
          class="dropdown__list-item-divider"/>
        <li v-if="userIsAdmin">
          <a :href="routeCompanies">Sociétés</a>
        </li>
        <li v-if="userIsAdmin">
          <a :href="routeDeliveries">Livraisons</a>
        </li>
        <li v-if="userIsAdmin">
          <a :href="routeDocuments">Documents</a>
        </li>
        <li
          v-if="userIsAdmin"
          class="dropdown__list-item-divider"/>
        <li v-if="userIsAdmin">
          <a :href="routeFormats">Formats</a>
        </li>
        <li v-if="userIsAdmin">
          <a :href="routeArticles">Articles</a>
        </li>
        <li v-if="userIsAdmin">
          <a :href="routeTicker">Ticker</a>
        </li>
        <li v-if="userIsAdmin">
          <a :href="routeUsers">Utilisateurs</a>
        </li>
        <li>
          <a
            :href="routeLegacyApp"
            target="_blank"
            rel="noopener noreferrer">
            Ancienne application
            <i class="fal fa-external-link"/>
          </a>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import mixins from "../../mixins";

export default {
  mixins: [mixins],
  props: {
    label: {
      type: String,
      required: true
    },
    userRole: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      open: false
    };
  },
  computed: {
    userIsAdmin() {
      return this.userRole === "administrateur";
    },
    routeProfile() {
      return window.route("profile.index");
    },
    routeLogout() {
      return window.route("logout");
    },
    routeCompanies() {
      return window.route("admin.companies.index");
    },
    routeDeliveries() {
      return window.route("deliveries.index");
    },
    routeDocuments() {
      return window.route("documents.index");
    },
    routeFormats() {
      return window.route("admin.formats.index");
    },
    routeArticles() {
      return window.route("admin.articles.index");
    },
    routeUsers() {
      return window.route("admin.users.index");
    },
    routeTicker() {
      return window.route("admin.tickers.index");
    },
    routeLegacyApp() {
      if (this.appName === "Dipnet") {
        return "http://dipnet.dip.ch/";
      } else if (this.appName === "Multicop") {
        return "http://multiprint.multicop.ch/";
      }
    }
  },
  created() {
    document.addEventListener("click", this.documentClick);
  },
  destroyed() {
    document.removeEventListener("click", this.documentClick);
  },
  methods: {
    /**
     * Toggle the open state of the dropdown list.
     */
    toggleOpen() {
      this.open = !this.open;
    },
    /**
     * Retrieve the reference of the active dropdown and close
     * it if another element is clicked.
     */
    documentClick(event) {
      let el = this.$refs.dropdownMenu;
      let target = event.target;
      if (el !== target && !el.contains(target)) {
        this.open = false;
      }
    }
  }
};
</script>

<style scoped>
svg {
  margin-left: 1rem;
}
</style>