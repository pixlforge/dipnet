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
            <div class="modal-panel" v-if="showModal" @keyup.esc="toggleModal" @keyup.enter="updateFormat">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-10 col-lg-8 offset-lg-1">

                            <!--Title-->
                            <h3 class="mt-7 mb-5">Modifier le format</h3>

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
                                           v-model.trim="format.name"
                                           required autofocus>
                                    <div class="help-block" v-if="errors.name" v-text="errors.name[0]"></div>
                                </div>

                                <!--Height-->
                                <div class="form-group my-5">
                                    <label for="height">Hauteur</label>
                                    <span class="required">requis</span>
                                    <input type="number"
                                           id="height"
                                           name="height"
                                           class="form-control"
                                           placeholder="e.g. 297mm"
                                           v-model.trim="format.height"
                                           required>
                                    <div class="help-block" v-if="errors.height" v-text="errors.height[0]"></div>
                                </div>

                                <!--Width-->
                                <div class="form-group my-5">
                                    <label for="width">Largeur</label>
                                    <span class="required">requis</span>
                                    <input type="number"
                                           id="width"
                                           name="width"
                                           class="form-control"
                                           placeholder="e.g. 210mm"
                                           v-model.trim="format.width"
                                           required>
                                    <div class="help-block" v-if="errors.width" v-text="errors.width[0]"></div>
                                </div>

                                <!--Surface-->
                                <div class="form-group my-5">
                                    <label for="surface">Surface</label>
                                    <input type="text"
                                           id="surface"
                                           name="surface"
                                           class="form-control"
                                           placeholder="e.g. 62'500mm2"
                                           v-model.trim="format.surface">
                                    <div class="help-block" v-if="errors.surface" v-text="errors.surface[0]"></div>
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
                                                @click.prevent="updateFormat">
                                            Modifier
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
    import {eventBus} from '../app';
    import mixins from '../mixins';

    export default {
        props: ['data'],
        data() {
            return {
                format: {
                    id: this.data.id,
                    name: this.data.name,
                    height: this.data.height,
                    width: this.data.width,
                    surface: this.data.surface
                },
                errors: {}
            };
        },
        components: {
            'app-moon-loader': MoonLoader
        },
        mixins: [mixins],
        methods: {
            updateFormat() {
                this.toggleLoader();

                axios.put('/formats/' + this.format.id, this.format)
                    .then(() => {
                        eventBus.$emit('formatWasUpdated', this.format);
                    })
                    .then(() => {
                        this.toggleLoader();
                        this.toggleModal();
                    })
                    .catch(error => {
                        this.toggleLoader();
                        this.errors = error.response.data;
                    });
            }
        }
    }
</script>