<template>
    <form class="form-inline form-nav"
          @submit.prevent>
        <i class="fa fa-search"></i>
        <input type="text"
               class="form-control searchbar"
               placeholder="Rechercher"
               v-model="search.query"
               @keyup="research">
        <div class="search-dropdown list-unstyled"
             v-if="search.query">

            <div v-if="results.orders.length">
                <h6 class="search-title">Orders</h6>
                <li v-for="(result, index) in results.orders">
                    <a :href="'/orders/' + result.id">{{ result.reference }}</a>
                </li>
            </div>

            <div v-if="results.companies.length">
                <hr v-if="results.orders.length">
                <h6 class="search-title">Companies</h6>
                <li v-for="(result, index) in results.companies">
                    <a :href="'/companies/' + result.id">{{ result.name }}</a>
                </li>
            </div>

            <div v-if="results.businesses.length">
                <hr v-if="results.orders.length || results.companies.length">
                <h6 class="search-title">Businesses</h6>
                <li v-for="(result, index) in results.businesses">
                    <a :href="'/businesses/' + result.id">{{ result.name }}</a>
                </li>
            </div>

            <div v-if="results.deliveries.length">
                <hr v-if="results.orders.length || results.companies.length || results.businesses.length">
                <h6 class="search-title">Deliveries</h6>
                <li v-for="(result, index) in results.deliveries">
                    <a :href="'/deliveries/' + result.id">{{ result.reference }}</a>
                </li>
            </div>

            <li v-if="!results.orders.length && !results.companies.length && !results.businesses.length && !results.deliveries.length">Aucun résultat</li>
        </div>
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
                    deliveries: []
                }
            }
        },
        methods: {
            research() {
                axios.post('/search', this.search)
                    .then(response => {
                        console.log(response.data);
                        this.results.orders = response.data[0];
                        this.results.companies = response.data[1];
                        this.results.businesses = response.data[2];
                        this.results.deliveries = response.data[3];
                    })
                    .catch(error => {
                        console.log(error.response.data);
                    });
            }
        }
    }
</script>

<style scoped>
    a {
        display: block;
        color: inherit;
        text-decoration: none;
    }
</style>