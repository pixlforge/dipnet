<template>
    <form class="form-inline form-nav"
          @submit.prevent>
        <i class="fa fa-search"></i>
        <input type="text" id="orders" class="form-control" placeholder="Rechercher">
    </form>
</template>

<script>
    import { orderautocomplete } from '../autocomplete';

    export default {
        mounted() {
            orderautocomplete('#orders');
        },
        methods: {
        }
    }
</script>