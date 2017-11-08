<template>
    <div>

        <!--Button-->
        <a class="dropdown-item" role="button" @click.stop="toggleModal">
            <i class="fal fa-pencil"></i>
            <span class="ml-3">Modifier</span>
        </a>

        <!--Background-->
        <transition name="fade">
            <div class="modal-background" v-if="showModal" @click="toggleModal"></div>
        </transition>

        <!--Modal Panel-->
        <transition name="slide">
            <div class="modal-panel" v-if="showModal" @keyup.esc="toggleModal" @keyup.enter="updateArticle">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-10 col-lg-8 offset-lg-1">

                            <!--Title-->
                            <h3 class="mt-7 mb-5">Modifier l'article</h3>

                            <!--Form-->
                            <form @submit.prevent>

                                <!--Reference-->
                                <div class="form-group">
                                    <label for="reference">Référence</label>
                                    <span class="required">*</span>
                                    <input type="text"
                                           id="reference"
                                           name="reference"
                                           class="form-control"
                                           v-model.trim="article.reference"
                                           required autofocus>
                                    <div class="help-block"
                                         v-if="errors.reference"
                                         v-text="errors.reference[0]">
                                    </div>
                                </div>

                                <!--Description-->
                                <div class="form-group my-5">
                                    <label for="description">Description</label>
                                    <input type="text"
                                           id="description"
                                           name="description"
                                           class="form-control"
                                           v-model.trim="article.description">
                                    <div class="help-block"
                                         v-if="errors.description"
                                         v-text="errors.description[0]">
                                    </div>
                                </div>

                                <!--Type-->
                                <div class="form-group my-5">
                                    <label for="type">Type</label>
                                    <select name="type"
                                            id="type"
                                            class="form-control custom-select"
                                            v-model.trim="article.type">
                                        <option disabled>Sélectionnez un type</option>
                                        <option value="option">Option</option>
                                        <option value="impression">Impression</option>
                                    </select>
                                </div>

                                <!--Buttons-->
                                <div class="form-group d-flex flex-column flex-lg-row my-6">
                                    <div class="col-12 col-lg-5 px-0 pr-lg-2">
                                        <button class="btn btn-block btn-lg btn-white"
                                                @click.stop="toggleModal">
                                            <i class="fal fa-times mr-2"></i>
                                            Annuler
                                        </button>
                                    </div>
                                    <div class="col-12 col-lg-7 px-0 pl-lg-2">
                                        <button class="btn btn-block btn-lg btn-black"
                                                @click.prevent="updateArticle">
                                            <i class="fal fa-check mr-2"></i>
                                            Modifier
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!--Loader-->
                <app-moon-loader :loading="loader.loading"
                                 :color="loader.color"
                                 :size="loader.size">
                </app-moon-loader>
            </div>
        </transition>
    </div>
</template>

<script>
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue'
    import { eventBus } from '../../app'
    import mixins from '../../mixins'

    export default {
        props: ['data-article'],
        data() {
            return {
                article: this.dataArticle,
                categories: this.dataCategories,
                errors: {}
            }
        },
        mixins: [mixins],
        components: {
            'app-moon-loader': MoonLoader
        },
        methods: {

            /**
             * Update an article.
             */
            updateArticle() {
                this.toggleLoader()

                axios.put('/articles/' + this.article.id, this.article)
                    .then(() => {
                        eventBus.$emit('articleWasUpdated', this.article)
                    })
                    .then(() => {
                        this.toggleLoader()
                        this.toggleModal()
                    })
                    .catch((error) => {
                        this.toggleLoader()
                        if (error.response.status === 422) {
                            flash({
                                message: "Erreur. La validation a échoué.",
                                level: 'danger'
                            })
                            return;
                        }
                        flash({
                            message: "Erreur. Veuillez réessayer plus tard.",
                            level: 'danger'
                        })
                    })
            }
        }
    }
</script>
