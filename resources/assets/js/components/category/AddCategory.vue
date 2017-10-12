<template>
    <div>

        <!--Button-->
        <a class="btn btn-lg btn-black mt-5" role="button" @click="toggleModal">
            <i class="fal fa-plus-circle mr-2"></i>
            Nouvelle catégorie
        </a>

        <!--Background-->
        <transition name="fade">
            <div class="modal-background" v-if="showModal" @click="toggleModal"></div>
        </transition>

        <!--Modal Panel-->
        <transition name="slide">
            <div class="modal-panel" v-if="showModal" @keyup.esc="toggleModal" @keyup.enter="addCategory">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-10 col-lg-8 offset-lg-1">

                            <!--Title-->
                            <h3 class="mt-7 mb-5">Nouvelle catégorie</h3>

                            <!--Form-->
                            <form @submit.prevent>

                                <!--Name-->
                                <div class="form-group">
                                    <label for="name">Nom</label>
                                    <span class="required">*</span>
                                    <input type="text"
                                           id="name"
                                           name="name"
                                           class="form-control"
                                           v-model.trim="category.name"
                                           required autofocus>
                                    <div class="help-block" v-if="errors.name" v-text="errors.name[0]"></div>
                                </div>

                                <!--Buttons-->
                                <div class="form-group d-flex flex-column flex-lg-row my-6">
                                    <div class="col-12 col-lg-5 px-0 pr-lg-2">
                                        <button class="btn btn-lg btn-block btn-white"
                                                @click.stop="toggleModal">
                                            <i class="fal fa-times mr-2"></i>
                                            Annuler
                                        </button>
                                    </div>
                                    <div class="col-12 col-lg-7 px-0 pl-lg-2">
                                        <button class="btn btn-lg btn-block btn-black"
                                                @click.prevent="addCategory">
                                            <i class="fal fa-check mr-2"></i>
                                            Ajouter
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <app-moon-loader :loading="loader.loading"
                                 :color="loader.color"
                                 :size="loader.size"></app-moon-loader>
            </div>
        </transition>
    </div>
</template>

<script>
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue';
    import mixins from '../../mixins';

    export default {
        data() {
            return {
                category: {
                    name: ''
                },
                errors: {}
            }
        },
        mixins: [mixins],
        components: {
            'app-moon-loader': MoonLoader
        },
        methods: {
            addCategory() {
                this.toggleLoader();

                axios.post('/categories', this.category)
                    .then(response => {
                        this.category.id = response.data;
                        this.$emit('categoryWasCreated', this.category);
                    })
                    .then(() => {
                        this.toggleLoader();
                        this.toggleModal();
                        this.category = {};
                    })
                    .catch(error => {
                        this.toggleLoader();
                        this.errors = error.response.data;
                        flash({
                            message: "Une erreur s'est produite.",
                            level: 'danger'
                        })
                    });
            }
        }
    }
</script>