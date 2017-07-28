<template>
    <ul class="pagination" v-if="shouldPaginate">
        <li class="page-item" v-show="prevUrl">
            <a class="page-link" href="" rel="prev" aria-label="Previous" @click.prevent="page--">
                <span aria-hidden="true">&laquo; Précédent</span>
                <span class="sr-only">Précédent</span>
            </a>
        </li>
        <li class="page-item" v-show="nextUrl">
            <a class="page-link" href="" rel="next" aria-label="Next" @click.prevent="page++">
                <span aria-hidden="true">Suivant &raquo;</span>
                <span class="sr-only">Suivant</span>
            </a>
        </li>
    </ul>
</template>

<script>
    export default {
        props: ['dataSet'],

        data() {
            return {
                page: 1,
                prevUrl: false,
                nextUrl: false
            }
        },

        watch: {
            dataSet() {
                this.prevUrl = this.dataSet.prev_page_url;
                this.nextUrl = this.dataSet.next_page_url;
            },

            page() {
                this.broadcast();
            }
        },

        computed: {
            shouldPaginate() {
                return !! this.prevUrl || !! this.nextUrl;
            }
        },

        methods: {
            broadcast() {
                this.$emit('updated', this.page);
            }
        }
    }
</script>