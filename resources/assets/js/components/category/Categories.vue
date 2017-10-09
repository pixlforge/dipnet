<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-10 my-5 mx-auto">
                <div class="row">
                    <div class="col-12 d-flex flex-column flex-lg-row justify-content-between align-items-center center-on-small-only">
                        <h1 class="mt-5">Catégories</h1>
                        <span class="mt-5">
                            {{ categories.length }}
                            {{ categories.length == 0 || categories.length == 1 ? 'résultat' : 'résultats' }}
                        </span>
                        <app-add-category @categoryWasCreated="addCategory"></app-add-category>
                    </div>
                </div>
            </div>
        </div>
        <div class="row bg-grey-light">
            <div class="col-10 mx-auto my-7">
                <transition-group name="highlight">
                    <app-category class="card card-custom center-on-small-only"
                                v-for="(category, index) in categories"
                                :data="category"
                                :key="category"
                                @categoryWasDeleted="removeCategory(index)">
                    </app-category>
                </transition-group>
                <app-moon-loader :loading="loader.loading"
                                 :color="loader.color"
                                 :size="loader.size"></app-moon-loader>
            </div>
        </div>
    </div>
</template>

<script>
    import Category from './Category.vue';
    import AddCategory from './AddCategory.vue';
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue';
    import {eventBus} from '../../app';
    import mixins from '../../mixins';

    export default {
        props: ['data'],
        data() {
            return {
                categories: this.data
            };
        },
        mixins: [mixins],
        components: {
            'app-category': Category,
            'app-add-category': AddCategory,
            'app-moon-loader': MoonLoader
        },
        created() {
            eventBus.$on('categoryWasUpdated', (data) => {
                this.updateCategory(data);
            })
        },
        methods: {
            addCategory(category) {
                this.categories.unshift(category);
                flash({
                    message: "La création de la catégorie a réussi.",
                    level: 'success'
                });
            },
            updateCategory(data) {
                for (let category of this.categories) {
                    if (data.id === category.id) {
                        category.name = data.name;
                    }
                }
                flash({
                    message: "Les modifications apportées à la catégorie ont été enregistrées.",
                    level: 'success'
                });
            },
            removeCategory(index) {
                this.categories.splice(index, 1);
                flash({
                    message: "Suppression de la catégorie réussie.",
                    level: 'success'
                });
            }
        }
    }
</script>