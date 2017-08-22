<template>
    <div>
        <a class="dropdown-item" role="link" @click.stop="toggleModal">
            <i class="fa fa-pencil"></i>
            <span class="ml-3">Modifier</span>
        </a>

        <!--Background-->
        <transition name="fade">
            <div class="modal-background" v-if="showModal" @click.stop="toggleModal"></div>
        </transition>

        <!--Modal Panel-->
        <transition name="slide">
            <div class="modal-panel" v-if="showModal" @keyup.esc="toggleModal" @keyup.enter="updateCategory">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-10 col-lg-8 offset-lg-1">

                            <!--Title-->
                            <h3 class="mt-7 mb-5">Modifier la catégorie</h3>

                            <!--Form-->
                            <form @submit.prevent>

                                <!--Name-->
                                <div class="form-group">
                                    <label for="name">Nom</label>
                                    <span class="required">requis</span>
                                    <input type="text"
                                           id="name"
                                           name="name"
                                           class="form-control"
                                           placeholder="e.g. A4"
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
                                                @click.prevent="updateCategory">
                                            Modifier
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <moon-loader :loading="loading" :color="color" :size="size"></moon-loader>
            </div>
        </transition>
    </div>
</template>

<script>
    import MoonLoader from 'vue-spinner/src/MoonLoader.vue';
    import {eventBus} from '../app';

    export default {
        props: ['data'],
        data() {
            return {
                category: {
                    id: this.data.id,
                    name: this.data.name
                },
                errors: {},
                color: '#fff',
                size: '96px',
                loading: false,
                showModal: false
            };
        },
        components: { MoonLoader },
        methods: {
            toggleModal() {
                this.showModal === false ? this.showModal = true : this.showModal = false;
            },
            updateCategory() {
                this.loading = true;

                axios.put('/categories/' + this.category.id, this.category)
                    .then(() => {
                        eventBus.$emit('categoryWasUpdated', this.category);
                    })
                    .then(() => {
                        this.loading = false;
                        this.showModal = false;
                    })
                    .catch(error => {
                        this.loading = false;
                        this.errors = error.response.data;
                    });
            }
        }
    }
</script>