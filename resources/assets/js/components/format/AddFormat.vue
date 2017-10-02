<template>
    <div>

        <!--Button-->
        <a @click="toggleModal" class="btn btn-lg btn-black mt-5" role="button">
            Nouveau format
        </a>

        <!--Background-->
        <transition name="fade">
            <div class="modal-background" v-if="showModal" @click="toggleModal"></div>
        </transition>

        <!--Modal Panel-->
        <transition name="slide">
            <div class="modal-panel" v-if="showModal" @keyup.esc="toggleModal" @keyup.enter="addFormat">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-10 col-lg-8 offset-lg-1">

                            <!--Title-->
                            <h3 class="mt-7 mb-5">Nouveau format</h3>

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
                                           v-model.trim="format.name"
                                           required autofocus>
                                    <div class="help-block" v-if="errors.name" v-text="errors.name[0]"></div>
                                </div>

                                <!--Height-->
                                <div class="form-group my-5">
                                    <label for="height">Hauteur</label>
                                    <span class="required">*</span>
                                    <input type="number"
                                           id="height"
                                           name="height"
                                           class="form-control"
                                           v-model.trim="format.height"
                                           required>
                                    <div class="help-block" v-if="errors.height" v-text="errors.height[0]"></div>
                                </div>

                                <!--Width-->
                                <div class="form-group my-5">
                                    <label for="width">Largeur</label>
                                    <span class="required">*</span>
                                    <input type="number"
                                           id="width"
                                           name="width"
                                           class="form-control"
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
                                                @click.prevent="addFormat">
                                            Ajouter
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <app-moon-loader :loading="loader.loading" :color="loader.color" :size="loader.size"></app-moon-loader>
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
                format: {
                    name: '',
                    height: '',
                    width: '',
                    surface: ''
                },
                errors: {}
            }
        },
        components: {
            'app-moon-loader': MoonLoader
        },
        mixins: [mixins],
        methods: {
            addFormat() {
                this.toggleLoader();

                axios.post('/formats', this.format)
                    .then(response => {
                        this.format.id = response.data;
                        this.$emit('formatWasCreated', this.format);
                    })
                    .then(() => {
                        this.toggleLoader();
                        this.toggleModal();
                        this.format = {};
                    })
                    .catch(error => {
                        this.toggleLoader();
                        this.errors = error.response.data;
                    });
            }
        }
    }
</script>