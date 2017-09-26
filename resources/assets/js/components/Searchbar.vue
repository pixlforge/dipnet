<template>
    <form class="form-inline form-nav"
          @submit.prevent>
        <i class="fa fa-search"></i>
        <input type="text"
               class="form-control"
               placeholder="Rechercher"
               v-model="search.query"
               @keyup="research">
        <div class="search-dropdown"
             v-if="results.companies.length || results.orders.length">
            <li v-for="(result, index) in results.orders"
                v-text="result.reference"></li>
            <li v-for="(result, index) in results.companies"
                v-text="result.name"></li>

            <li v-if="results.length === 0">Aucun résultat</li>
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