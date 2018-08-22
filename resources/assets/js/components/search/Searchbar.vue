<template>
  <form
    class="searchbar"
    @submit.prevent>
    <i class="fal fa-search"/>
    <input
      v-model="search.query"
      :class="search.query.length ? 'searchbar__not-empty' : ''"
      type="text"
      class="searchbar__input"
      placeholder="Rechercher"
      @keyup.prevent="debounceInput">
    <transition name="fade">
      <ul
        v-if="search.query.length > 1"
        class="searchbar__dropdown">
        <li v-if="searching">Recherche en cours...</li>
        
        <!-- Orders -->
        <div v-if="containsOrders">
          <h6 class="searchbar__title">Commandes</h6>
          <li
            v-for="result in results.orders"
            :key="result.id">
            <a :href="getOrderUrl(result)">
              {{ result.reference }}
            </a>
          </li>
        </div>

        <!-- Deliveries -->
        <div v-if="containsDeliveries">
          <li
            v-if="containsOrders || containsCompanies || containsBusinesses"
            class="dropdown__list-item-divider"/>
          <h6 class="searchbar__title">Livraisons</h6>
          <li
            v-for="result in results.deliveries"
            :key="result.id">
            <a :href="getDeliveryOrderUrl(result)">
              {{ result.reference }}
            </a>
          </li>
        </div>
        
        <!-- Companies -->
        <div v-if="containsCompanies">
          <li
            v-if="containsOrders"
            class="dropdown__list-item-divider"/>
          <h6 class="searchbar__title">Sociétés</h6>
          <li
            v-for="result in results.companies"
            :key="result.id">
            <a :href="getCompanyUrl(result)">
              {{ result.name }}
            </a>
          </li>
        </div>
        
        <!-- Businesses -->
        <div v-if="containsBusinesses">
          <li
            v-if="containsOrders || containsCompanies"
            class="dropdown__list-item-divider"/>
          <h6 class="searchbar__title">Affaires</h6>
          <li
            v-for="result in results.businesses"
            :key="result.id">
            <a :href="getBusinessUrl(result)">
              {{ result.name }}
            </a>
          </li>
        </div>
        
        <!-- Contacts -->
        <div v-if="containsContacts">
          <li
            v-if="containsOrders || containsCompanies || containsBusinesses || containsDeliveries"
            class="dropdown__list-item-divider"/>
          <h6 class="searchbar__title">Contacts</h6>
          <li
            v-for="result in results.contacts"
            :key="result.id">
            <a :href="getContactUrl(result)">
              {{ result.name }}
            </a>
          </li>
        </div>

        <!-- No result -->
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
  props: {
    userRole: {
      type: String,
      required: true
    }
  },
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
    },
    userIsAdmin() {
      return this.userRole === "administrateur";
    }
  },
  methods: {
    debounceInput: window._.debounce(function() {
      if (this.search.query.length > 1) {
        window.axios
          .post(window.route("search.query"), this.search)
          .then(response => {
            this.results.orders = response.data[0];
            this.results.companies = response.data[1];
            this.results.businesses = response.data[2];
            this.results.deliveries = response.data[3];
            this.results.contacts = response.data[4];
          });
      }
    }, 500),
    getOrderUrl(result) {
      if (this.userIsAdmin) {
        return `/admin/commandes/${result.reference}/voir`;
      } else {
        return `/commandes/${result.reference}/details`;
      }
    },
    getDeliveryOrderUrl(result) {
      if (this.userIsAdmin) {
        return `/admin/commandes/${result.order.reference}/voir`;
      } else {
        return `/commandes/${result.order.reference}/details`;
      }
    },
    getBusinessUrl(result) {
      return `/affaires/${result.reference}/details`;
    },
    getContactUrl(result) {
      return `/contacts/${result.id}/details`;
    },
    getCompanyUrl(result) {
      return `/societes/${result.slug}`;
    }
  }
};
</script>
