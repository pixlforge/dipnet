<template>
    <div class="d-flex flex-column align-items-center" v-if="shouldPaginate">
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link" href="" rel="prev" aria-label="Previous" @click.prevent="prevPage">
                    <span aria-hidden="true">&laquo; Précédent</span>
                    <span class="sr-only">Précédent</span>
                </a>
            </li>

            <li class="page-item">
                <a class="page-link" href="" rel="next" aria-label="Next" @click.prevent="nextPage">
                    <span aria-hidden="true">Suivant &raquo;</span>
                    <span class="sr-only">Suivant</span>
                </a>
            </li>
        </ul>
        <!--<p class="d-block">Résultats {{ dataSet.from }} à {{ dataSet.to }} ({{ dataSet.total }} total)</p>-->
    </div>
</template>

<script>
    export default {
        props: ['dataSet'],
        data() {
            return {
                page: 1,
                prevUrl: this.dataSet.prev_page_url,
                nextUrl: this.dataSet.next_page_url
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
            },

            prevPage() {
                if (this.page > 1) {
                    this.page--;
                }
            },

            nextPage() {
                if (this.page < this.dataSet.last_page) {
                    this.page++;
                }
            }
        }
    }
</script>