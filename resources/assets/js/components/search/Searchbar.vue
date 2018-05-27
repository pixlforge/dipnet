<template>
  <form class="searchbar">
    <i class="fal fa-search"/>
    <input
      v-model="search.query"
      :class="search.query.length ? 'searchbar__not-empty' : ''"
      type="text"
      class="searchbar__input"
      placeholder="Rechercher"
      @keyup="research">
    <transition name="fade">
      <ul
        v-if="search.query.length > 1"
        class="searchbar__dropdown">
        <li v-if="searching">Recherche en cours...</li>
        
        <div v-if="containsOrders">
          <h6 class="searchbar__title">Commandes</h6>
          <li
            v-for="(result, index) in results.orders"
            :key="index">
            <a :href="'/orders/' + result.id">{{ result.reference }}</a>
          </li>
        </div>
        
        <div v-if="containsCompanies">
          <li
            v-if="containsOrders"
            class="dropdown__list-item-divider"/>
          <h6 class="searchbar__title">Sociétés</h6>
          <li
            v-for="(result, index) in results.companies"
            :key="index">
            <a :href="'/companies/' + result.id">{{ result.name }}</a>
          </li>
        </div>
        
        <div v-if="containsBusinesses">
          <li
            v-if="containsOrders || containsCompanies"
            class="dropdown__list-item-divider"/>
          <h6 class="searchbar__title">Affaires</h6>
          <li
            v-for="(result, index) in results.businesses"
            :key="index">
            <a :href="'/businesses/' + result.id">{{ result.name }}</a>
          </li>
        </div>
        
        <div v-if="containsDeliveries">
          <li
            v-if="containsOrders || containsCompanies || containsBusinesses"
            class="dropdown__list-item-divider"/>
          <h6 class="searchbar__title">Livraisons</h6>
          <li
            v-for="(result, index) in results.deliveries"
            :key="index">
            <a :href="'/deliveries/' + result.id">{{ result.reference }}</a>
          </li>
        </div>
        
        <div v-if="containsContacts">
          <li
            v-if="containsOrders || containsCompanies || containsBusinesses || containsDeliveries"
            class="dropdown__list-item-divider"/>
          <h6 class="searchbar__title">Contacts</h6>
          <li
            v-for="(result, index) in results.contacts"
            :key="index">
            <a :href="'/contacts/' + result.id">{{ result.name }}</a>
          </li>
        </div>

        <li
          v-if="search.query.length > 1 && !searching && !containsOrders && !containsCompanies && !containsBusinesses && !containsDeliveries && !containsContacts">
          Aucun résultat
        </li>
      </ul>
    </transition>
  </form>
</template>

<script>
export default {
  data() {
    return {
      search: {
        query: ""
      },
      results: {
        orders: [],
        companies: [],
        businesses: [],
        deliveries: [],
        contacts: []
      },
      searching: false
    };
  },
  computed: {
    containsOrders() {
      return this.results.orders.length;
    },
    containsCompanies() {
      return this.results.companies.length;
    },
    containsBusinesses() {
      return this.results.businesses.length;
    },
    containsDeliveries() {
      return this.results.deliveries.length;
    },
    containsContacts() {
      return this.results.contacts.length;
    }
  },
  methods: {
    research() {
      if (this.search.query.length > 1) {
        this.toggleSearch();
        window.axios
          .post(window.route("search.query"), this.search)
          .then(response => {
            this.results.orders = response.data[0];
            this.results.companies = response.data[1];
            this.results.businesses = response.data[2];
            this.results.deliveries = response.data[3];
            this.results.contacts = response.data[4];
            this.toggleSearch();
          })
          .catch(() => {
            this.toggleSearch();
          });
      }
    },
    toggleSearch() {
      this.searching = !this.searching;
    }
  }
};
</script>
