<template>
  <form class="form-inline form-nav" @submit.prevent>
    <i class="fal fa-search"></i>
    <input type="text"
           class="form-control searchbar"
           :class="search.query.length ? 'searchbar-not-empty' : ''"
           placeholder="Rechercher"
           v-model="search.query"
           @keyup="research">

    <transition name="fade">
      <div class="search-dropdown list-unstyled"
           v-if="search.query.length > 1">

        <li v-if="searching">Recherche en cours...</li>

        <div v-if="containsOrders">
          <h6 class="search-title">Commandes</h6>
          <li v-for="(result, index) in results.orders">
            <a :href="'/orders/' + result.id">{{ result.reference }}</a>
          </li>
        </div>

        <div v-if="containsCompanies">
          <hr v-if="containsOrders">
          <h6 class="search-title">Sociétés</h6>
          <li v-for="(result, index) in results.companies">
            <a :href="'/companies/' + result.id">{{ result.name }}</a>
          </li>
        </div>

        <div v-if="containsBusinesses">
          <hr v-if="containsOrders || containsCompanies">
          <h6 class="search-title">Affaires</h6>
          <li v-for="(result, index) in results.businesses">
            <a :href="'/businesses/' + result.id">{{ result.name }}</a>
          </li>
        </div>

        <div v-if="containsDeliveries">
          <hr v-if="containsOrders || containsCompanies || containsBusinesses">
          <h6 class="search-title">Livraisons</h6>
          <li v-for="(result, index) in results.deliveries">
            <a :href="'/deliveries/' + result.id">{{ result.reference }}</a>
          </li>
        </div>

        <div v-if="containsContacts">
          <hr v-if="containsOrders || containsCompanies || containsBusinesses || containsDeliveries">
          <h6 class="search-title">Contacts</h6>
          <li v-for="(result, index) in results.contacts">
            <a :href="'/contacts/' + result.id">{{ result.name }}</a>
          </li>
        </div>

        <li
          v-if="search.query.length > 1 && !searching && !containsOrders && !containsCompanies && !containsBusinesses && !containsDeliveries && !containsContacts">
          Aucun résultat
        </li>
      </div>
    </transition>
  </form>
</template>

<script>
  export default {
    data() {
      return {
        search: {
          query: ''
        },
        results: {
          orders: [],
          companies: [],
          businesses: [],
          deliveries: [],
          contacts: []
        },
        searching: false
      }
    },
    computed: {
      containsOrders() {
        return this.results.orders.length
      },
      containsCompanies() {
        return this.results.companies.length
      },
      containsBusinesses() {
        return this.results.businesses.length
      },
      containsDeliveries() {
        return this.results.deliveries.length
      },
      containsContacts() {
        return this.results.contacts.length
      },
    },
    methods: {

      /**
       * Search
       */
      research() {
        if (this.search.query.length > 1) {
          this.toggleSearch()

          axios.post(route('search.query'), this.search)
            .then(response => {
              this.results.orders = response.data[0]
              this.results.companies = response.data[1]
              this.results.businesses = response.data[2]
              this.results.deliveries = response.data[3]
              this.results.contacts = response.data[4]
              this.toggleSearch()
            })
            .catch(error => {
              this.toggleSearch()
            })
        }
      },

      /**
       * Toggle searching state.
       */
      toggleSearch() {
        this.searching = !this.searching
      }
    }
  }
</script>

<style scoped>
  .searchbar-not-empty {
    background-color: white !important;
    box-shadow: 0 6px 14px 0 rgba(200, 200, 200, 0.5);
  }

  a {
    display: block;
    color: inherit;
    text-decoration: none;
  }
</style>