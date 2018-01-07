<template>
  <form class="searchbar" @submit.prevent>
    <i class="fal fa-search"></i>
    <input type="text"
           class="searchbar__input"
           :class="search.query.length ? 'searchbar__not-empty' : ''"
           placeholder="Rechercher"
           v-model="search.query"
           @keyup="research">
    <transition name="fade">
      <ul class="searchbar__dropdown"
           v-if="search.query.length > 1">
        <li v-if="searching">Recherche en cours...</li>
        <div v-if="containsOrders">
          <h6 class="searchbar__title">Commandes</h6>
          <li v-for="(result, index) in results.orders">
            <a :href="'/orders/' + result.id">{{ result.reference }}</a>
          </li>
        </div>
        <div v-if="containsCompanies">
          <li class="dropdown__list-item-divider"
              v-if="containsOrders">
          </li>
          <h6 class="searchbar__title">Sociétés</h6>
          <li v-for="(result, index) in results.companies">
            <a :href="'/companies/' + result.id">{{ result.name }}</a>
          </li>
        </div>
        <div v-if="containsBusinesses">
          <li class="dropdown__list-item-divider"
              v-if="containsOrders || containsCompanies">
          </li>
          <h6 class="searchbar__title">Affaires</h6>
          <li v-for="(result, index) in results.businesses">
            <a :href="'/businesses/' + result.id">{{ result.name }}</a>
          </li>
        </div>
        <div v-if="containsDeliveries">
          <li class="dropdown__list-item-divider"
              v-if="containsOrders || containsCompanies || containsBusinesses">
          </li>
          <h6 class="searchbar__title">Livraisons</h6>
          <li v-for="(result, index) in results.deliveries">
            <a :href="'/deliveries/' + result.id">{{ result.reference }}</a>
          </li>
        </div>
        <div v-if="containsContacts">
          <li class="dropdown__list-item-divider"
              v-if="containsOrders || containsCompanies || containsBusinesses || containsDeliveries">
          </li>
          <h6 class="searchbar__title">Contacts</h6>
          <li v-for="(result, index) in results.contacts">
            <a :href="'/contacts/' + result.id">{{ result.name }}</a>
          </li>
        </div>
        <li v-if="search.query.length > 1 && !searching && !containsOrders && !containsCompanies && !containsBusinesses && !containsDeliveries && !containsContacts">
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
