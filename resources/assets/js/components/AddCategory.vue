<template>
    <div>

        <!--Button-->
        <a @click="toggleModal" class="btn btn-lg btn-black mt-5" role="button">
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
                                        <button class="btn btn-block btn-lg btn-white"
                                                @click.stop="toggleModal">
                                            Annuler
                                        </button>
                                    </div>
                                    <div class="col-12 col-lg-7 px-0 pl-lg-2">
                                        <button class="btn btn-block btn-lg btn-black"
                                                @click.prevent="addCategory">
                                            Ajouter
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <app-moon-loader :loading="loader.loading" :color="loader.color" :size="loader.size">
                </app-moon-loader>
            </div>
        </transition>
    </div>
</template>

<script>
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue';
    import mixins from '../mixins';

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
                    });
            }
        }
    }
</script>